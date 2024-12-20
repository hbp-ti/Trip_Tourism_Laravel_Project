<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Room;
use App\Models\OrderItem;
use App\Models\Activity;
use App\Models\Hotel;

class PaymentController extends Controller
{
    public function paymentPhases(Request $request)
    {
        $locale = $request->route('locale');
        $phase = $request->input('phase');
        $paymentMethod = $request->input('paymentMethod');

        switch ($phase) {
            case 1:
                return view('payment.payment1');
                break;

            case 2:
                // Armazena o método de pagamento na sessão
                if ($paymentMethod) {
                    $request->session()->put('paymentMethod', $paymentMethod);
                }

                $billingInfo = [
                    'address' => $request->input('address'),
                    'address2' => $request->input('address2'),
                    'country' => $request->input('country'),
                    'city' => $request->input('city'),
                    'zip' => $request->input('zip'),
                ];

                // Armazena as informações de faturação na sessão
                $request->session()->put('billingInfo', $billingInfo);

                if (!Auth::check()) {
                    $popupError = PopupHelper::showPopup('Authentication!', 'You must be logged in to proceed with payment.', 'Error', 'OK', false, '', 5000);
                    return redirect()
                        ->route('auth.login.form', ['locale' => $locale])
                        ->with('popup', $popupError);
                }

                $user = Auth::user();
                $cart = Cart::firstOrCreate(['user_id' => $user->id], ['subtotal' => 0, 'taxes' => 0, 'total' => 0]);

                $cartItems = $cart->cartItems()->get();

                $cartItemsWithDetails = $cartItems->map(function ($cartItem) {
                    $item = $cartItem->item;
                    $taxRate = 0.05; // 4% de taxa (1.04 representa um aumento de 4%)

                    if ($item->item_type === 'Hotel') {
                        // Buscar detalhes do hotel relacionado
                        $hotel = Hotel::where('id_item', $item->id)->first();

                        // Buscar o quarto na tabela Room com base no tipo de quarto e ID do hotel
                        $room = Room::where('hotel_id', $hotel->id_item)
                            ->where('type', $cartItem->room_type_hotel)
                            ->first();

                        if (!$room) {
                            throw new \Exception("Room not found for hotel ID {$hotel->id} and room type {$cartItem->room_type_hotel}");
                        }

                        // Calcular preço total para Hotel
                        $checkin = \Carbon\Carbon::parse($cartItem->reservation_date_hotel_checkin);
                        $checkout = \Carbon\Carbon::parse($cartItem->reservation_date_hotel_checkout);
                        $daysDifference = $checkin->diffInDays($checkout);

                        $subtotal = $room->price_night * $daysDifference * $cartItem->numb_people_hotel;
                        $taxes = $subtotal * $taxRate; // Calcular o valor da taxa
                        $totalPrice = $subtotal + $taxes; // Somar a taxa ao subtotal para obter o total

                        // Associar detalhes ao cartItem
                        $cartItem->details = (object) [
                            'type' => 'Hotel',
                            'name' => $hotel->name,
                            'description' => $hotel->description,
                            'country' => $hotel->country,
                            'city' => $hotel->city,
                            'zip_code' => $hotel->zip_code,
                            'street' => $hotel->street,
                            'room_type' => $room->type,
                            'price_night' => $room->price_night,
                            'days_difference' => $daysDifference,
                            'numb_people' => $cartItem->numb_people_hotel,
                            'subtotal' => $subtotal,
                            'total_price' => $totalPrice,
                        ];
                    } elseif ($item->item_type === 'Activity') {
                        // Buscar detalhes da atividade relacionada
                        $activity = Activity::where('id_item', $item->id)->first();

                        // Calcular preço total para Activity
                        $subtotal = $activity->price_hour * $cartItem->numb_people_activity;
                        $taxes = $subtotal * $taxRate; // Calcular o valor da taxa
                        $totalPrice = $subtotal + $taxes; // Somar a taxa ao subtotal para obter o total

                        // Associar detalhes ao cartItem
                        $cartItem->details = (object) [
                            'type' => 'Activity',
                            'name' => $activity->name,
                            'description' => $activity->description,
                            'country' => $activity->country,
                            'city' => $activity->city,
                            'zip_code' => $activity->zip_code,
                            'street' => $activity->street,
                            'price_hour' => $activity->price_hour,
                            'numb_people' => $cartItem->numb_people_activity,
                            'subtotal' => $subtotal,
                            'total_price' => $totalPrice,
                        ];
                    }

                    return $cartItem;
                });
                return view('payment.payment2', compact('paymentMethod', 'billingInfo', 'cart', 'cartItems'));
                break;

            case 3:
                // Recupera os valores armazenados na sessão
                $paymentMethod = $request->session()->get('paymentMethod');
                $billingInfo = $request->session()->get('billingInfo');

                // Retorna a view com `compact`
                return view('payment.payment3', compact('paymentMethod', 'billingInfo'));
                break;

            default:
                abort(404, 'Invalid payment phase');
        }
    }
}
