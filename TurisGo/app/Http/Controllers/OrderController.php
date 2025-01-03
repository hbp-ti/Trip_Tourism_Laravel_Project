<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Activity;
use App\Models\Ticket;
use App\Helpers\PopupHelper;

class OrderController extends Controller
{
    public function getOrderDetail(Request $request)
    {

        $locale = $request->route('locale');

        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Not Authorized');
        }
    }

    public function cancelReservation(Request $request)
    {
        $orderId = $request->input('order_id');
        $itemId = $request->input('item_id');
        // Obtenha o pedido do usuário autenticado, incluindo os itens do pedido
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id()) // Garantir que o pedido pertence ao usuário autenticado
            ->with('orderItems')
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pedido não encontrado!');
        }

        // Encontre o item no pedido
        $orderItem = $order->orderItems->firstWhere('item_id', $itemId);

        // Verifique se o item foi encontrado e se o atributo is_active é true
        if ($orderItem && $orderItem->is_active) {
            // Armazenar o subtotal do item antes da remoção
            $itemSubtotal = 0;
            $itemTotalPrice = 0;

            // Verifica o tipo do item (Hotel, Activity, Ticket) para calcular o subtotal e total
            $item = $orderItem->item;

            if ($item->item_type === 'Hotel') {
                // Buscar detalhes do hotel relacionado
                $hotel = Hotel::where('id_item', $item->id)->first();

                // Buscar o quarto na tabela Room com base no tipo de quarto e ID do hotel
                $room = Room::where('hotel_id', $hotel->id_item)
                    ->where('type', $orderItem->room_type_hotel)
                    ->first();

                if (!$room) {
                    throw new \Exception("Room not found for hotel ID {$hotel->id} and room type {$orderItem->room_type_hotel}");
                }

                // Calcular preço total para Hotel
                $checkin = \Carbon\Carbon::parse($orderItem->reservation_date_hotel_checkin);
                $checkout = \Carbon\Carbon::parse($orderItem->reservation_date_hotel_checkout);
                $daysDifference = $checkin->diffInDays($checkout);

                $itemSubtotal = $room->price_night * $daysDifference * $orderItem->numb_people_hotel;
            } elseif ($item->item_type === 'Activity') {
                // Buscar detalhes da atividade relacionada
                $activity = Activity::where('id_item', $item->id)->first();

                // Calcular preço total para Activity
                $itemSubtotal = $activity->price_hour * $orderItem->numb_people_activity;
            } elseif ($item->item_type === 'Ticket') {
                // Buscar detalhes do ticket relacionado
                $ticket = Ticket::where('id_item', $item->id)->first();

                // Calcular preço total para Ticket
                $itemSubtotal = $ticket->total_price * $ticket->quantity;
            }

            // Aplica a taxa de 5% sobre o subtotal
            $taxRate = 0.05; // Taxa de 5%
            $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
            $itemTotalPrice = $itemSubtotal + $taxes; // Somar a taxa ao subtotal para obter o total
            // Remover o item do pedido
            $orderItem->delete(); // Excluir o item

            // Recalcular o total do pedido
            $subtotalOrder = 0;
            $taxesOrder = 0;
            $totalOrder = 0;

            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id()) // Garantir que o pedido pertence ao usuário autenticado
                ->with('orderItems')
                ->first();

            if (!$order) {
                return redirect()->back()->with('error', 'Pedido não encontrado!');
            }

            // Recalcular os totais dos itens restantes
            foreach ($order->orderItems as $remainingItem) {
                $itemSubtotal = 0;
                $itemTotalPrice = 0;

                if ($remainingItem->item->item_type === 'Hotel') {
                    // Buscar detalhes do hotel relacionado
                    $hotel = Hotel::where('id_item', $remainingItem->item->id)->first();
                    $room = Room::where('hotel_id', $hotel->id_item)
                        ->where('type', $remainingItem->room_type_hotel)
                        ->first();

                    if (!$room) {
                        throw new \Exception("Room not found for hotel ID {$hotel->id} and room type {$remainingItem->room_type_hotel}");
                    }

                    // Calcular preço total para Hotel
                    $checkin = \Carbon\Carbon::parse($remainingItem->reservation_date_hotel_checkin);
                    $checkout = \Carbon\Carbon::parse($remainingItem->reservation_date_hotel_checkout);
                    $daysDifference = $checkin->diffInDays($checkout);

                    $itemSubtotal = $room->price_night * $daysDifference * $remainingItem->numb_people_hotel;
                    dd($itemSubtotal);
                } elseif ($remainingItem->item->item_type === 'Activity') {
                    // Buscar detalhes da atividade relacionada
                    $activity = Activity::where('id_item', $remainingItem->item->id)->first();

                    // Calcular preço total para Activity
                    $itemSubtotal = $activity->price_hour * $remainingItem->numb_people_activity;
                } elseif ($remainingItem->item->item_type === 'Ticket') {
                    // Buscar detalhes do ticket relacionado
                    $ticket = Ticket::where('id_item', $remainingItem->item->id)->first();

                    // Calcular preço total para Ticket
                    $itemSubtotal = $ticket->total_price * $ticket->quantity;
                }

                // Aplica a taxa de 5% sobre o subtotal
                $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
                $itemTotalPrice = $itemSubtotal + $taxes; // Somar a taxa ao subtotal para obter o total

                // Atualiza o valor total do pedido com os novos valores
                $subtotalOrder += $itemSubtotal;
                $taxesOrder += $taxes;
                $totalOrder += $itemTotalPrice;
            }
            // Atualizar o pedido com o novo subtotal, taxas e total
            $order->subtotal = $subtotalOrder;
            $order->taxes = $taxesOrder;
            $order->total = $totalOrder;  // Novo total do pedido com a taxa aplicada
            $order->save();

            dd($subtotalOrder);

            $popup = PopupHelper::showPopup(
                'Success!',
                'Your reservation has been canceled successfully',
                'success',
                'OK',
                false,
                '',
                5000
            );



            return redirect()->route('auth.profile.show', ['locale' => app()->getLocale()])->with('popup', $popup);
        }

        $popupError = PopupHelper::showPopup(
            'Error!',
            'There was an error canceling your reservation',
            'error',
            'OK',
            false,
            '',
            5000
        );

        return redirect()->route('auth.profile.show', ['locale' => app()->getLocale()])->with('popup', $popupError);
    }


    public function downloadOrder(Request $request, $id)
    {
        $id = $request->input('id');
        // Buscar o pedido (order) pelo ID
        $order = Order::with(['orderItems' => function ($query) {
            $query->with(['item' => function ($query) {
                $query->select('id', 'item_type');
            }]);
        }, 'user' => function ($query) {
            $query->select('id', 'first_name', 'last_name', 'email', 'username', 'phone'); // Selecionando apenas os campos necessários
        }])->findOrFail($id);  // Carrega o pedido com os 'orderItems' e o 'user'

        $orderItems = $order->orderItems->map(function ($orderItem) {
            $item = $orderItem->item;
            $taxRate = 0.05;
            // Verificar o tipo de item e buscar as informações correspondentes
            switch ($item->item_type) {
                case 'Ticket':

                    $ticket = Ticket::where('id_item', $item->id)->first();

                    $subtotal = $ticket->total_price * $ticket->quantity;
                    $taxes = $subtotal * $taxRate;
                    $totalPrice = $subtotal + $taxes;
                    $orderItem->details = (object) [
                        'name' => $ticket->origin . '->' . $ticket->destination,
                        'subtotal' => $subtotal,
                        'total_price' => $totalPrice,
                    ];
                    break;
                case 'Activity':
                    // Buscar dados da atividade
                    $activity = Activity::where('id_item', $item->id)->first();

                    $subtotal = $activity->price_hour * $orderItem->numb_people_activity;
                    $taxes = $subtotal * $taxRate;
                    $totalPrice = $subtotal + $taxes;
                    $orderItem->details = (object) [
                        'name' => $activity->name,
                        'subtotal' => $subtotal,
                        'total_price' => $totalPrice,
                    ];
                    break;
                case 'Hotel':
                    // Buscar dados do hotel
                    $hotel = Hotel::where('id_item', $item->id)->first();
                    $room = Room::where('hotel_id', $hotel->id_item)
                        ->where('type', $orderItem->room_type_hotel)
                        ->first();

                    $checkin = \Carbon\Carbon::parse($orderItem->reservation_date_hotel_checkin);
                    $checkout = \Carbon\Carbon::parse($orderItem->reservation_date_hotel_checkout);
                    $daysDifference = $checkin->diffInDays($checkout);

                    $subtotal = $room->price_night * $daysDifference * $orderItem->numb_people_hotel;
                    $taxes = $subtotal * $taxRate;
                    $totalPrice = $subtotal + $taxes;
                    $orderItem->details = $hotel;

                    $orderItem->details = (object) [
                        'name' => $hotel->name,
                        'subtotal' => $subtotal,
                        'total_price' => $totalPrice,
                    ];
                    break;
                default:
                    $orderItem->details = null; // Caso não seja um tipo reconhecido
                    break;
            }
            return $orderItem;
        });

        $date = now()->format('Y-m-d_H-i-s');
        // Dados para o PDF
        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'date' => now()->format('d-m-Y'),
        ];

        // Gerar PDF usando a view 'invoice'
        $pdf = PDF::loadView('components/pdfInvoice', $data);

        $pdf->download("TurisGo_order_{$id}_{$date}.pdf");

        return $pdf->download("TurisGo_order_{$id}_{$date}.pdf");
    }
}
