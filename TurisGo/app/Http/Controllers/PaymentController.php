<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Ticket;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Room;
use App\Models\OrderItem;
use App\Models\Activity;
use App\Models\Hotel;
use App\Helpers\PopupHelper;

use function Symfony\Component\String\b;

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
                // Recupera os valores armazenados na sessão
                $paymentMethod = $request->session()->get('paymentMethod') ?? 'unknown';
                $billingInfo = $request->session()->get('billingInfo');

                if ($billingInfo && isset($billingInfo['expires_at']) && now()->lessThan($billingInfo['expires_at'])) {
                    $billingInfo = $billingInfo['data'];
                } else {
                    $request->session()->forget('billingInfo');
                    $billingInfo = null;
                }
                dd($billingInfo);
                // Limpar o carrinho do utilizador após o pagamento
                if (Auth::check()) {
                    $user = Auth::user();
                    $cart = Cart::where('user_id', $user->id)->first();

                    if ($cart) {
                        // Apagar os itens do carrinho
                        $cart->cartItems()->delete();

                        // Reset aos valores do carrinho (opcional)
                        $cart->update([
                            'subtotal' => 0,
                            'taxes' => 0,
                            'total' => 0,
                        ]);
                    }
                }

                return view('payment.payment3', compact('paymentMethod', 'billingInfo'));

            default:
                abort(404, 'Invalid payment phase');
        }
    }
}
