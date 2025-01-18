<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Room;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Activity;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Helpers\PopupHelper;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function paymentPhases(Request $request)
    {
        $locale = $request->route('locale');

        $validatedData = $request->validate([
            'phase' => 'required|integer|in:1,2,3',
            'paymentMethod' => 'nullable|string|in:mbway,paypal,multibanco',
            'address' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
        ]);

        $phase = $validatedData['phase'];
        $paymentMethod = $validatedData['paymentMethod'] ?? null; // Valor padrão se não estiver presente

        switch ($phase) {
            case 1:
                $billingInfo = $request->session()->get('billingInfo');

                if ($billingInfo && isset($billingInfo['expires_at']) && now()->lessThan($billingInfo['expires_at'])) {
                    $billingInfo = $billingInfo['data'];
                } else {
                    $request->session()->forget('billingInfo');
                    $billingInfo = null;
                }

                return view('payment.payment1');

            case 2:
                if ($paymentMethod) {
                    $request->session()->put('paymentMethod', $paymentMethod);
                }

                $billingInfo = [
                    'address' => $validatedData['address'] ?? null,
                    'address2' => $validatedData['address2'] ?? null,
                    'country' => $validatedData['country'] ?? null,
                    'city' => $validatedData['city'] ?? null,
                    'zip' => $validatedData['zip'] ?? null,
                ];
         
                $request->session()->put('billingInfo', [
                    'data' => $billingInfo,
                    'expires_at' => now()->addMinutes(10),
                ]);

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
                    $taxRate = 0.05;

                    if ($item->item_type === 'Hotel') {
                        $hotel = Hotel::where('id_item', $item->id)->first();

                        if (!$hotel) {
                            throw new \Exception("Hotel not found for item ID {$item->id}");
                        }

                        $room = Room::where('hotel_id', $hotel->id_item)
                            ->where('type', $cartItem->room_type_hotel)
                            ->first();

                        if (!$room) {
                            throw new \Exception("Room not found for hotel ID {$hotel->id_item} and room type {$cartItem->room_type_hotel}");
                        }

                        $checkin = \Carbon\Carbon::parse($cartItem->reservation_date_hotel_checkin);
                        $checkout = \Carbon\Carbon::parse($cartItem->reservation_date_hotel_checkout);
                        $daysDifference = $checkin->diffInDays($checkout);

                        $subtotal = $room->price_night * $daysDifference * $cartItem->numb_people_hotel;
                        $taxes = $subtotal * $taxRate;
                        $totalPrice = $subtotal + $taxes;

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
                        $activity = Activity::where('id_item', $item->id)->first();

                        if (!$activity) {
                            throw new \Exception("Activity not found for item ID {$item->id}");
                        }

                        $subtotal = $activity->price_hour * $cartItem->numb_people_activity;
                        $taxes = $subtotal * $taxRate;
                        $totalPrice = $subtotal + $taxes;

                        $cartItem->details = (object) [
                            'type' => 'Activity',
                            'name' => $activity->name,
                            'description' => $activity->description,
                            'country' => $activity->country,
                            'city' => $activity->city,
                            'zip_code' => $activity->zip_code,
                            'street' => $activity->street,
                            'checkin' => $cartItem->date_activity,
                            'language' => $activity->language,
                            'price_hour' => $activity->price_hour,
                            'numb_people' => $cartItem->numb_people_activity,
                            'subtotal' => $subtotal,
                            'total_price' => $totalPrice,
                        ];
                    } elseif ($item->item_type === 'Ticket') {
                        $ticket = Ticket::where('id_item', $item->id)->first();

                        if (!$ticket) {
                            throw new \Exception("Ticket not found for item ID {$item->id}");
                        }

                        $subtotal = $ticket->total_price * $ticket->quantity;
                        $taxes = $subtotal * $taxRate;
                        $totalPrice = $subtotal + $taxes;

                        $cartItem->details = (object) [
                            'type' => 'Ticket',
                            'name' => $ticket->origin . '->' . $ticket->destination,
                            'train_type' => $ticket->train_type,
                            'train_class' => $ticket->train_class,
                            'departure_hour' => $ticket->departure_hour,
                            'quantity' => $ticket->quantity,
                            'is_used' => $ticket->is_used,
                            'origin' => $ticket->origin,
                            'destination' => $ticket->destination,
                            'subtotal' => $subtotal,
                            'total_price' => $totalPrice,
                        ];
                    }

                    return $cartItem;
                });

                return view('payment.payment2', compact('paymentMethod', 'cart', 'cartItems'));

            case 3:

                if (!Auth::check()) {
                    $popupError = PopupHelper::showPopup('Authentication!', 'You must be logged in to proceed with payment.', 'Error', 'OK', false, '', 5000);
                    return redirect()
                        ->route('auth.login.form', ['locale' => $locale])
                        ->with('popup', $popupError);
                }

                $user = Auth::user();
                $cart = Cart::firstOrCreate(['user_id' => $user->id], ['subtotal' => 0, 'taxes' => 0, 'total' => 0]);
                
                // Recupera os valores armazenados na sessão
                $paymentMethod = $request->session()->get('paymentMethod') ?? 'unknown';
                $billingInfo = $request->session()->get('billingInfo');

                if ($billingInfo && isset($billingInfo['expires_at']) && now()->lessThan($billingInfo['expires_at'])) {
                    $billingInfo = $billingInfo['data'];
                } else {
                    $request->session()->forget('billingInfo');
                    $billingInfo = null;
                }

                return view('payment.payment3', compact('paymentMethod', 'billingInfo', 'cart'));

            default:
                abort(404, 'Invalid payment phase');
        }
    }

    public function processPayment(Request $request)
    {   

        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'You must be logged in to process the payment.');
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems()->count() === 0) {
            return redirect()->route('auth.cart.show', ['locale' => app()->getLocale()])->with('error', 'Your cart is empty.');
        }

        // Iniciar transação para segurança
        DB::beginTransaction();

        try {

            $order = Order::create([
                'subtotal' => $cart->subtotal,
                'taxes' => $cart->taxes,
                'total' => $cart->total,
                'date' => now()->toDateString(),
                'payment_method' => $request->session()->get('paymentMethod') ?? 'unknown',
                'billing_country' => $request->session()->get('billingInfo')['data']['country'] ?? null,
                'billing_city' => $request->session()->get('billingInfo')['data']['city'] ?? null,
                'billing_address' => $request->session()->get('billingInfo')['data']['address'] ?? null,
                'billing_postal_code' => $request->session()->get('billingInfo')['data']['zip'] ?? null,
                'user_id' => $user->id,
            ]);

            // Mover os itens do carrinho para os itens do pedido
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'numb_people_hotel' => $cartItem->numb_people_hotel,
                    'room_type_hotel' => $cartItem->room_type_hotel,
                    'reservation_date_hotel_checkin' => $cartItem->reservation_date_hotel_checkin,
                    'reservation_date_hotel_checkout' => $cartItem->reservation_date_hotel_checkout,
                    'numb_people_activity' => $cartItem->numb_people_activity,
                    'hours_activity' => $cartItem->hours_activity,
                    'date_activity' => $cartItem->date_activity,
                    'train_date' => $cartItem->train_date,
                    'train_type' => $cartItem->train_type,
                    'train_people_count' => $cartItem->train_people_count,
                    'order_id' => $order->id,
                    'item_id' => $cartItem->item_id,
                    'is_active' => true,
                ]);
            }

            Notification::create([
                'title' => 'Payment Successful',
                'description' => 'Your payment of ' . $order->total . ' was successfully processed.',
                'is_read' => false,
                'user_id' => $user->id,
            ]);

            // Limpar o carrinho e os itens do carrinho
            $cart->cartItems()->delete();
            $cart->update([
                'subtotal' => 0,
                'taxes' => 0,
                'total' => 0,
            ]);

            // Confirma a transação
            DB::commit();

            $popup = PopupHelper::showPopup(
                'Your payment was successful!',
                'Your order was successfully processed. Thank you for your purchase!',
                'Success',
                'OK',
                false,
                '',
                10000
            );

            return redirect()->route('auth.cart.show', ['locale' => app()->getLocale()])->with('popup', $popup);
        } catch (\Exception $e) {
            $popupError = PopupHelper::showPopup(
                'An error occurred!',
                'An error occurred while processing your payment. Please try again later.',
                'Error',
                'OK',
                false,
                '',
                5000
            );
            // Reverte a transação em caso de erro
            DB::rollBack();
            return back()->with('popup', $popupError);
        }
    }
}
