<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Room;
use App\Models\OrderItem;
use App\Models\Activity;
use Illuminate\Support\Facades\Http;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\Hotel;
use App\Helpers\PopupHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $apiBaseUri;

    public function __construct()
    {
        // Configura o URI base da API a partir do arquivo de configuração
        $this->apiBaseUri = config('services.train_api.base_uri');
    }
    public function showRegistrationForm(Request $request)
    {
        $locale = $request->route('locale');
        return view('auth.register', compact('locale'));
    }

    public function register(Request $request)
    {
        $locale = $request->route('locale');

        try {
            // Validação dos dados recebidos
            $validatedData = $request->validate([
                'first_name' => 'required|max:20',
                'last_name' => 'required|max:20',
                'email' => 'required|email|unique:users',
                'username' => 'required|max:20|unique:users',
                'phone' => 'required|integer',
                'birth_date' => 'required|date',
                'password' => [
                    'required',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[.\@$!%*?&_-]/',
                    'confirmed',
                ],
            ]);

            // Criação do usuário
            User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'birth_date' => $validatedData['birth_date'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
                'image' => 'images/default_user_image.png',
                'is_admin' => false,
            ]);

            // Popup de sucesso
            $popup = PopupHelper::showPopup(
                'Success!',
                'Your registration was completed successfully. Please log in to continue.',
                'success',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.login.form', ['locale' => $locale])->with('popup', $popup);
        } catch (\Illuminate\Database\QueryException $e) {
            // Tratamento do erro caso o email ou username já estejam em uso
            if ($e->getCode() == '23000') {
                // Código de erro relacionado a violação de chave única (unique constraint violation)
                $popup = PopupHelper::showPopup(
                    'Error',
                    'The email or username you entered is already in use. Please choose a different one.',
                    'error',
                    'OK',
                    false,
                    '',
                    0
                );
                return back()->with('popup', $popup);
            }

            // Outro tipo de erro inesperado
            $popup = PopupHelper::showPopup(
                'Error',
                'An unexpected error occurred. Please check the credentials!',
                'error',
                'OK',
                false,
                '',
                0
            );
            return back()->with('popup', $popup);
        }
    }


    public function showLoginForm(Request $request)
    {
        $locale = $request->route('locale');
        return view('auth.login', compact('locale'));
    }

    public function login(Request $request)
    {
        $locale = $request->route('locale');

        $validatedData = $request->validate([
            'email_username' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $fieldType = filter_var($validatedData['email_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $validatedData['email_username'], 'password' => $validatedData['password']], $request->has('remember'))) {
            return redirect()->route('homepage', ['locale' => $locale]);
        }

        $popup = PopupHelper::showPopup(
            'Login Failed',
            'Invalid email or password. Please try again.',
            'error',
            'Try Again',
            false,
            '',
            0
        );

        return back()->with('popup', $popup);
    }

    public function logout(Request $request)
    {
        $locale = $request->route('locale');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage', ['locale' => $locale]);
    }

    public function showForgotForm(Request $request)
    {
        $locale = $request->route('locale');
        return view('auth.forgot', compact('locale'));
    }

    public function sendResetLink(Request $request)
    {
        $locale = $request->route('locale');

        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(['email' => $request->email], ['token' => $token, 'created_at' => now()]);
        $resetLink = url(route('reset.form', ['locale' => $locale, 'token' => $token, 'email' => $request->email], false));

        Mail::to($request->email)->send(new PasswordResetMail($resetLink));

        $popup = PopupHelper::showPopup('Success!', 'If your account exists you will receive a reset link to your email.', 'success', 'OK', false, '', 5000);
        return back()->with('popup', $popup);
    }

    public function showResetForm(Request $request, $token, $email)
    {
        $locale = $request->route('locale');

        $resetRecord = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$resetRecord || $resetRecord->email !== $email) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Invalid or expired token');
        }

        session()->flash('reset_token', $token);
        session()->flash('reset_email', $email);

        return view('auth.reset', compact('locale'));
    }

    public function resetPassword(Request $request)
    {
        $locale = $request->route('locale');

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[.\@$!%*?&_-]/',
                'confirmed',
            ],
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('token', $request->token)->where('email', $request->email)->first();

        if (!$resetRecord) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Invalid or expired token');
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $popup = PopupHelper::showPopup('Success!', 'Your password has been reset.', 'success', 'Continue', false, '', 5000);

        return redirect()->route('auth.login.form', ['locale' => $locale])->with('popup', $popup);
    }

    public function showProfile(Request $request)
    {
        $locale = $request->route('locale');

        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Not Authorized');
        }

        $user = Auth::user();

        // Obtenção das reservas ativas
        $activeReservations = OrderItem::where('is_active', true)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['item.images'])
            ->get();

        // Obtenção das reservas expiradas
        $expiredReservations = OrderItem::where('is_active', false)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['item.images'])
            ->get();

        // Adicionar detalhes aos itens das reservas ativas
        $activeReservationsWithDetails = $activeReservations->map(function ($reservationItem) {
            $item = $reservationItem->item;
            $taxRate = 0.05; // Taxa de 5%

            // Processamento para o tipo de item Hotel
            if ($item->item_type === 'Hotel') {
                $hotel = Hotel::where('id_item', $item->id)->first();
                $room = Room::where('hotel_id', $hotel->id_item)
                    ->where('type', $reservationItem->room_type_hotel)
                    ->first();

                if (!$room) {
                    throw new \Exception("Room not found for hotel ID {$hotel->id} and room type {$reservationItem->room_type_hotel}");
                }

                $checkin = \Carbon\Carbon::parse($reservationItem->reservation_date_hotel_checkin);
                $checkout = \Carbon\Carbon::parse($reservationItem->reservation_date_hotel_checkout);
                $daysDifference = $checkin->diffInDays($checkout);

                $subtotal = $room->price_night * $daysDifference * $reservationItem->numb_people_hotel;
                $taxes = $subtotal * $taxRate;
                $totalPrice = $subtotal + $taxes;

                // Associando detalhes ao item da reserva ativa
                $reservationItem->details = (object) [
                    'id' => $item->id,
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
                    'numb_people' => $reservationItem->numb_people_hotel,
                    'subtotal' => $subtotal,
                    'total_price' => $totalPrice,
                    'images' => $item->images
                ];
            }
            // Processamento para o tipo de item Activity
            elseif ($item->item_type === 'Activity') {
                $activity = Activity::where('id_item', $item->id)->first();

                $subtotal = $activity->price_hour * $reservationItem->numb_people_activity;
                $taxes = $subtotal * $taxRate;
                $totalPrice = $subtotal + $taxes;

                // Associando detalhes ao item da reserva ativa
                $reservationItem->details = (object) [
                    'id' => $item->id,
                    'type' => 'Activity',
                    'name' => $activity->name,
                    'description' => $activity->description,
                    'country' => $activity->country,
                    'city' => $activity->city,
                    'zip_code' => $activity->zip_code,
                    'street' => $activity->street,
                    'price_hour' => $activity->price_hour,
                    'numb_people' => $reservationItem->numb_people_activity,
                    'subtotal' => $subtotal,
                    'total_price' => $totalPrice,
                    'images' => $item->images
                ];
            }
            // Processamento para o tipo de item Ticket
            elseif ($item->item_type === 'Ticket') {
                $ticket = Ticket::where('id_item', $item->id)->first();

                $subtotal = $ticket->total_price * $ticket->quantity;
                $taxes = $subtotal * $taxRate;
                $totalPrice = $subtotal + $taxes;

                // Associando detalhes ao item da reserva ativa
                $reservationItem->details = (object) [
                    'id' => $item->id,
                    'train_id' => $ticket->train_id,
                    'type' => 'Ticket',
                    'name' => $ticket->origin . '->' . $ticket->destination,
                    'train_type' => $ticket->train_type,
                    'train_class' => $ticket->train_class,
                    'departure_hour' => $ticket->departure_hour,
                    'arrival_hour' => $ticket->arrival_hour,
                    'quantity' => $ticket->quantity,
                    'is_used' => $ticket->is_used,
                    'origin' => $ticket->origin,
                    'destination' => $ticket->destination,
                    'subtotal' => $subtotal,
                    'total_price' => $totalPrice,
                ];
            }

            return $reservationItem;
        });

        // Adicionar detalhes aos itens das reservas expiradas
        $expiredReservationsWithDetails = $expiredReservations->map(function ($reservationItem) {
            $item = $reservationItem->item;
            $taxRate = 0.05; // Taxa de 5%

            // Processamento para o tipo de item Hotel
            if ($item->item_type === 'Hotel') {
                $hotel = Hotel::where('id_item', $item->id)->first();
                $room = Room::where('hotel_id', $hotel->id_item)
                    ->where('type', $reservationItem->room_type_hotel)
                    ->first();

                if (!$room) {
                    throw new \Exception("Room not found for hotel ID {$hotel->id} and room type {$reservationItem->room_type_hotel}");
                }

                $checkin = \Carbon\Carbon::parse($reservationItem->reservation_date_hotel_checkin);
                $checkout = \Carbon\Carbon::parse($reservationItem->reservation_date_hotel_checkout);
                $daysDifference = $checkin->diffInDays($checkout);

                $subtotal = $room->price_night * $daysDifference * $reservationItem->numb_people_hotel;
                $taxes = $subtotal * $taxRate;
                $totalPrice = $subtotal + $taxes;

                // Associando detalhes ao item da reserva expirada
                $reservationItem->details = (object) [
                    'id' => $item->id,
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
                    'numb_people' => $reservationItem->numb_people_hotel,
                    'subtotal' => $subtotal,
                    'total_price' => $totalPrice,
                    'images' => $item->images
                ];
            }
            // Processamento para o tipo de item Activity
            elseif ($item->item_type === 'Activity') {
                $activity = Activity::where('id_item', $item->id)->first();

                $subtotal = $activity->price_hour * $reservationItem->numb_people_activity;
                $taxes = $subtotal * $taxRate;
                $totalPrice = $subtotal + $taxes;

                // Associando detalhes ao item da reserva expirada
                $reservationItem->details = (object) [
                    'id' => $item->id,
                    'type' => 'Activity',
                    'name' => $activity->name,
                    'description' => $activity->description,
                    'country' => $activity->country,
                    'city' => $activity->city,
                    'zip_code' => $activity->zip_code,
                    'street' => $activity->street,
                    'price_hour' => $activity->price_hour,
                    'numb_people' => $reservationItem->numb_people_activity,
                    'subtotal' => $subtotal,
                    'total_price' => $totalPrice,
                    'images' => $item->images
                ];
            }
            // Processamento para o tipo de item Ticket
            elseif ($item->item_type === 'Ticket') {
                $ticket = Ticket::where('id_item', $item->id)->first();

                $subtotal = $ticket->total_price * $ticket->quantity;
                $taxes = $subtotal * $taxRate;
                $totalPrice = $subtotal + $taxes;

                // Associando detalhes ao item da reserva expirada
                $reservationItem->details = (object) [
                    'id' => $item->id,
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

            return $reservationItem;
        });

        $orders = Order::where('user_id', $user->id)
            ->get();

        // Iterando por cada pedido
        $orders->map(function ($order) {
            // Para cada item de pedido, aplicamos o mapeamento
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

            // Atribui os itens atualizados ao pedido
            $order->orderItems = $orderItems;

            return $order;
        });


        return view('auth.profile', compact('user', 'activeReservations', 'expiredReservations', 'locale', 'orders'));
    }

    public function updateProfile(Request $request)
    {

        $locale = $request->route('locale');

        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Not Authorized');
        }

        try {
            $validatedData = $request->validate([
                'first_name' => 'required|max:20',
                'last_name' => 'required|max:20',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'username' => 'required|max:20|unique:users,username,' . Auth::id(),
                'phone' => 'required|integer',
            ]);

            // Encontrar e atualizar o usuário autenticado
            $user = User::find(Auth::id());
            $user->update($validatedData);

            // Criar popup de sucesso
            $popup = PopupHelper::showPopup(
                'Profile Updated!',
                'Your profile has been updated successfully.',
                'success',
                'OK',
                false,
                '',
                5000
            );

            // Redirecionar com popup
            return redirect()->route('auth.profile.show', ['locale' => $locale])->with('popup', $popup);
        } catch (\Exception $e) {
            // Caso ocorra um erro, enviar uma mensagem de erro
            $popup = PopupHelper::showPopup(
                'Error',
                'An error occurred while updating your profile. Please try again later.',
                'error',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.profile.show', ['locale' => $locale])->with('popup', $popup);
        }
    }


    public function updatePassword(Request $request)
    {
        // Pegando a localidade da rota, se aplicável
        $locale = $request->route('locale');

        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Not Authorized');
        }

        $validatedData = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($validatedData['oldPassword'], $user->password)) {

            // Exibindo um popup de sucesso
            $popup = PopupHelper::showPopup(
                'Password not updated!',
                'Oops! The current password you entered is not correct.',
                'error',
                'OK',
                false,
                '',
                5000
            );
            return redirect()->back()->with('popup', $popup);
        }

        $user->password = Hash::make($validatedData['newPassword']);
        $user->update();

        // Exibindo um popup de sucesso
        $popup = PopupHelper::showPopup(
            'Password Updated!',
            'Your password has been updated successfully.',
            'success',
            'OK',
            false,
            '',
            5000
        );

        // Redirecionando com sucesso
        return redirect()->route('auth.profile.show', ['locale' => $locale])->with('popup', $popup);
    }

    public function updateProfilePicture(Request $request)
    {

        $locale = $request->route('locale');

        if (!Auth::check()) {
            return response()->json(['error' => 'Not Authorized'], 401);
        }

        $user = User::find(Auth::id());

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public'); // Salvar a imagem no diretório "public/profile_pictures"

            // Atualize a imagem do perfil no banco de dados
            $user->profile_picture = $path;
            $user->update();

            $popupError = PopupHelper::showPopup(
                'Error updating your profile picture!',
                'Your profile picture couldnt be updated',
                'success',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.profile.show', ['locale' => $locale])->with('popup', $popupError);
        }

        $popup = PopupHelper::showPopup(
            'Porfile picture Updated!',
            'Your profile picture has been updated successfully.',
            'success',
            'OK',
            false,
            '',
            5000
        );

        return redirect()->route('auth.profile.show', ['locale' => $locale])->with('popup', $popup);
    }

    // Dentro do AuthController

    public function showCart(Request $request)
    {
        $locale = $request->route('locale');

        if (!Auth::check()) {
            $popupError = PopupHelper::showPopup(
                'Authentication!',
                'You must be logged in to add items to the cart',
                'error',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.login.form', ['locale' => $locale])->with('popup', $popupError);
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
            } elseif ($item->item_type === 'Ticket') {
                // Buscar detalhes da atividade relacionada
                $ticket = Ticket::where('id_item', $item->id)->first();

                // Calcular preço total para Activity
                $subtotal = $ticket->total_price * $ticket->quantity;
                $taxes = $subtotal * $taxRate; // Calcular o valor da taxa
                $totalPrice = $subtotal + $taxes; // Somar a taxa ao subtotal para obter o total

                // Associar detalhes ao cartItem
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

        return view('auth.cart', compact('cart', 'cartItems', 'locale'));
    }

    public function addToCart(Request $request)
    {


        $locale = $request->route('locale');
        $popupError = PopupHelper::showPopup(
            'Authentication!',
            'You must be logged in to add items to the cart',
            'error',
            'OK',
            false,
            '',
            5000
        );

        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])
                ->with('popup', $popupError);
        }

        if ($request->has(['journey', 'preference', 'passengers', 'date', 'class', 'from', 'to'])) {
            // Verifica se os parâmetros não estão vazios
            $validated = $request->validate([
                'journey' => 'required|string',
                'leg' => 'required|string',  // Exemplo de validação para uma string
                'preference' => 'required|string|max:255',
                'passengers' => 'required|integer|min:1', // Valida que é um número inteiro, com no mínimo 1 passageiro
                'date' => 'required|date', // Valida que a data é uma data válida
                'class' => 'required|string|max:50', // Exemplo para validar a classe, com string
                'from' => 'required|string|max:255', // Valida o local de origem
                'to' => 'required|string|max:255', // Valida o local de destino
            ]);

            $journey = $validated['journey'];
            $leg = $validated['leg'];
            $journeyObject = json_decode(urldecode($journey), true);
            $legObject = json_decode(urldecode($leg), true);
            $preference = $validated['preference'];
            $passengers = $validated['passengers'];
            $date = $validated['date'];
            $travelClass = $validated['class'];
            $from = $validated['from'];
            $to = $validated['to'];


            if (!empty($journey) && !empty($leg) && !empty($preference) && !empty($passengers) && !empty($date) && !empty($travelClass) && !empty($from) && !empty($to)) {
                // Criação do item
                $item = Item::create([
                    'item_type' => 'Ticket',
                ]);

                // Preparar os dados para a URL e o POST
                $itemId = $item->id;
                $request->merge(['itemId' => $itemId]);
            }
        }
        // Recuperar dados da requisição
        $itemId = $request->input('itemId');

        $item = Item::findOrFail($itemId);

        // Verificação do hash dependendo do tipo de item
        if ($item->item_type === 'Hotel') {
            // Para Hotéis, o hash será gerado com o price_night
            $roomId = $request->input('room_id');
            $room = Room::findOrFail($roomId); // Buscar o quarto específico
            $dataToHash = $room->id . '|' . $room->price_night;
            $itemHash = $request->input('item_hash.' . $roomId);
            $guestsCount = $request->input('guests.' . $room->id);
            $checkoutDate = $request->input('checkout_date.' . $room->id);
            $checkinDate = $request->input('checkin_date.' . $room->id);  // Check-in para Hotel ou Tour
        } elseif ($item->item_type === 'Activity') {
            $tour = Activity::where('id_item', $item->id)->firstOrFail();
            $dataToHash = $tour->id_item . '|' . $tour->price_hour;
            $itemHash = $request->input('item_hash.' . $tour->id_item);
            $guestsCount = $request->input('guests.' . $itemId);  // Número de pessoas (para Hotel ou Tour)
            $checkinDate = $request->input('checkin_date.' . $tour->id_item);  // Check-in para Hotel ou Tour
        } elseif ($item->item_type === 'Ticket') {
            $timestampTrain = \Carbon\Carbon::parse($legObject["departure"])->format('Y-m-d H:i:s');
            $dateTrain = \Carbon\Carbon::parse($legObject["departure"])->format('Y-m-d');
            $timeArrival =  \Carbon\Carbon::parse($legObject["arrival"])->format('Y-m-d H:i:s');
            $priceTrain = $journeyObject['price']['amount'];
            $train_id = $journeyObject['legs'][0]['line']['productCode'] . ' ' . $journeyObject['legs'][0]['line']['name'];
        } else {
            // Caso não seja nem Hotel, nem Activity/Tour, retornamos um erro
            $popupError2 = PopupHelper::showPopup(
                'Error!',
                'Invalid item type.',
                'error',
                'OK',
                false,
                '',
                5000
            );
            return back()->with('popup', $popupError2);
        }




        if ($item->item_type === 'Hotel' || $item->item_type === 'Activity') {
            // Gerar o hash esperado com base no tipo de item
            $expectedHash = hash_hmac('sha256', $dataToHash, config('app.key'));

            // Verificar se o hash enviado é válido
            if ($expectedHash !== $itemHash) {
                $popupError2 = PopupHelper::showPopup(
                    'Error!',
                    'The ids do not match.',
                    'error',
                    'OK',
                    false,
                    '',
                    5000
                );
                return back()->with('popup', $popupError2);
            }
        }

        // Adicionar item ao carrinho
        $user = Auth::user();

        // Criar ou obter o carrinho
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Preparar os dados para criação do item no carrinho
        $data = [
            'item_id' => $itemId,
            'cart_id' => $cart->id,
        ];

        // Variáveis de subtotal, taxa e total
        $itemSubtotal = 0;
        $taxes = 0;
        $itemTotal = 0;
        // Lógica para tipo "Hotel"
        if ($item->item_type === 'Hotel') {
            // Calcular as datas para Hotel
            $checkin = \Carbon\Carbon::parse($checkinDate);
            $checkout = \Carbon\Carbon::parse($checkoutDate);
            $daysDifference = $checkin->diffInDays($checkout);

            // Subtotal do Hotel: preço por noite * número de noites * número de pessoas
            $itemSubtotal = $room->price_night * $daysDifference * $guestsCount;
            $taxRate = 0.05; // Taxa fixa (ajustar conforme necessário)
            $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
            $itemTotal = $itemSubtotal + $taxes;
            // Adicionar dados específicos de Hotel
            $data['numb_people_hotel'] = $guestsCount;
            $data['room_type_hotel'] = $room->type;  // Tipo do quarto
            $data['reservation_date_hotel_checkin'] = $checkin;
            $data['reservation_date_hotel_checkout'] = $checkout;


            // Definir valores nulos para outros tipos de item
            $data['numb_people_activity'] = null;
            $data['hours_activity'] = null;
            $data['train_type'] = null;
            $data['train_people_count'] = null;
            $data['date_activity'] = null;
            $data['train_date'] = null;
        } else if ($item->item_type === 'Activity') {
            $hoursToAdd = $request->input('hours.' . $itemId);
            $formattedTime = sprintf("%02d:00:00", $hoursToAdd);
            // Subtotal do Tour: preço por hora * número de pessoas
            $itemSubtotal = $tour->price_hour * $guestsCount;
            $taxRate = 0.05; // Taxa fixa (ajustar conforme necessário)
            $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
            $itemTotal = $itemSubtotal + $taxes;
            // Adicionar dados específicos de Activity/Tour
            $data['numb_people_activity'] = $guestsCount;

            $data['hours_activity'] = $formattedTime;
            $data['date_activity'] = $checkinDate;  // Definido no frontend para Tour/Activity

            // Definir valores nulos para outros tipos de item
            $data['numb_people_hotel'] = null;
            $data['room_type_hotel'] = null;
            $data['reservation_date_hotel_checkin'] = null;
            $data['reservation_date_hotel_checkout'] = null;
            $data['train_type'] = null;
            $data['train_people_count'] = null;
            $data['train_date'] = null;
        } else if ($item->item_type === 'Ticket') {
            Ticket::create([
                'id_item' => $itemId,
                'transport_type' => 'Train',
                'train_class' => $travelClass,
                'train_type' => $preference,
                'departure_hour' => $timestampTrain,
                'arrival_hour' => $timeArrival,
                'quantity' => $passengers,
                'total_price' => $priceTrain,
                'origin' => $legObject['origin']['name'],
                'destination' => $legObject['destination']['name'],
                'train_id' => $train_id,
                'is_used' => false,
            ]);


            $itemSubtotal = $priceTrain * $passengers;
            $taxRate = 0.05; // Taxa fixa (ajustar conforme necessário)
            $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
            $itemTotal = $itemSubtotal + $taxes;

            // Para Tickets, o cálculo depende de "train_type" e "train_people_count"
            $data['train_type'] = $preference;
            $data['train_people_count'] = $passengers;
            $data['train_date'] = $dateTrain;

            // Definir valores nulos para outros tipos de item
            $data['numb_people_hotel'] = null;
            $data['room_type_hotel'] = null;
            $data['reservation_date_hotel_checkin'] = null;
            $data['reservation_date_hotel_checkout'] = null;
            $data['numb_people_activity'] = null;
            $data['hours_activity'] = null;
            $data['date_activity'] = null;
        }

        // Criar o item no carrinho
        $cart->cartItems()->create($data);

        // Somar os valores do novo item com os existentes no carrinho
        $newSubtotal = $cart->subtotal + $itemSubtotal;
        $newTaxes = $cart->taxes + $taxes;
        $newTotal = $cart->total + $itemTotal;

        // Atualizar os valores do carrinho
        $cart->subtotal = $newSubtotal;
        $cart->taxes = $newTaxes;
        $cart->total = $newTotal;
        $cart->save();

        // Exibir popup de sucesso
        $popupSuccess = PopupHelper::showPopup(
            'Success!',
            'The item has been added to your cart',
            'success',
            'OK',
            false,
            '',
            5000
        );


        if ($item->item_type === 'Hotel' || $item->item_type === 'Activity') {
            return back()->with('popup', $popupSuccess);
        } elseif ($item->item_type === 'Ticket') {

            return redirect()->route('auth.tickets', ['locale' => $locale])->with('popup', $popupSuccess);
        }
    }


    public function removeFromCart(Request $request)
    {
        $locale = $request->route('locale');
        //$cartItemJson = $request->route('cartItem');  // Recebe o objeto JSON como string

        // Decodifica o JSON de volta para um array ou objeto
        //$cartItemOld = json_decode(urldecode($cartItemJson));

        $cartItemOld = json_decode($request->input('cartItem'));
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            $popupError = PopupHelper::showPopup(
                'Authentication!',
                'You must be logged in to remove items from the cart',
                'error',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.login.form', ['locale' => $locale])
                ->with('popup', $popupError);
        }

        // Obtém o ID do usuário autenticado
        $userId = Auth::id();

        // Verifica se o CartItem pertence ao carrinho do usuário autenticado
        $cartItem = CartItem::where('id', $cartItemOld->id)  // Usando o id do objeto cartItem
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();

        if ($cartItem) {
            // Armazena o subtotal e total do item antes da remoção
            $itemSubtotal = 0;
            $itemTotalPrice = 0;

            // Verifica o tipo do item (Hotel ou Activity) para calcular o subtotal e total
            $item = $cartItem->item;

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

                $itemSubtotal = $room->price_night * $daysDifference * $cartItem->numb_people_hotel;
            } elseif ($item->item_type === 'Activity') {
                // Buscar detalhes da atividade relacionada
                $activity = Activity::where('id_item', $item->id)->first();

                // Calcular preço total para Activity
                $itemSubtotal = $activity->price_hour * $cartItem->numb_people_activity;
            } elseif ($item->item_type === 'Ticket') {
                // Buscar detalhes da atividade relacionada
                $ticket = Ticket::where('id_item', $item->id)->first();

                // Calcular preço total para Activity
                $itemSubtotal = $ticket->total_price * $ticket->quantity;
            }

            // Aplica a taxa de 5% sobre o subtotal
            $taxRate = 0.05; // Taxa de 5%
            $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
            $itemTotalPrice = $itemSubtotal + $taxes; // Somar a taxa ao subtotal para obter o total

            // Remover o item do carrinho
            $cartItem->delete();

            // Atualizar o total do carrinho
            $cart = Cart::where('user_id', $userId)->first();

            if ($cart) {
                // Recalcular o subtotal, taxas e total do carrinho
                $cartItems = $cart->cartItems;

                $subtotalCart = 0;
                $taxesCart = 0;
                $totalCart = 0;

                foreach ($cartItems as $item) {
                    // Para cada item, calcula a taxa
                    $itemSubtotal = 0;
                    $itemTotalPrice = 0;

                    if ($item->item->item_type === 'Hotel') {
                        // Buscar detalhes do hotel relacionado
                        $hotel = Hotel::where('id_item', $item->item->id)->first();
                        $room = Room::where('hotel_id', $hotel->id_item)
                            ->where('type', $item->room_type_hotel)
                            ->first();

                        if (!$room) {
                            throw new \Exception("Room not found for hotel ID {$hotel->id} and room type {$item->room_type_hotel}");
                        }

                        // Calcular preço total para Hotel
                        $checkin = \Carbon\Carbon::parse($item->reservation_date_hotel_checkin);
                        $checkout = \Carbon\Carbon::parse($item->reservation_date_hotel_checkout);
                        $daysDifference = $checkin->diffInDays($checkout);

                        $itemSubtotal = $room->price_night * $daysDifference * $item->numb_people_hotel;
                    } elseif ($item->item->item_type === 'Activity') {
                        // Buscar detalhes da atividade relacionada
                        $activity = Activity::where('id_item', $item->item->id)->first();

                        // Calcular preço total para Activity
                        $itemSubtotal = $activity->price_hour * $item->numb_people_activity;
                    }

                    // Aplica a taxa de 5% sobre o subtotal
                    $taxes = $itemSubtotal * $taxRate; // Calcular o valor da taxa
                    $itemTotalPrice = $itemSubtotal + $taxes; // Somar a taxa ao subtotal para obter o total

                    // Atualiza o valor total do carrinho com os novos valores
                    $subtotalCart += $itemSubtotal;
                    $taxesCart += $taxes;
                    $totalCart += $itemTotalPrice;
                }

                // Atualiza o carrinho com o novo subtotal, taxas e total
                $cart->subtotal = $subtotalCart;
                $cart->taxes = $taxesCart;
                $cart->total = $totalCart;  // Novo total do carrinho com a taxa aplicada
                $cart->save();
            }

            // Retorna a mensagem de sucesso
            $popupSuccess = PopupHelper::showPopup(
                'Success!',
                'The item has been removed from your cart successfully',
                'success',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.cart.show', ['locale' => $locale])
                ->with('popup', $popupSuccess);
        }

        // Caso não encontre o CartItem
        $popupError = PopupHelper::showPopup(
            'Error!',
            'There was an error deleting the item from the cart',
            'error',
            'OK',
            false,
            '',
            5000
        );

        return back()->with('popup', $popupError);
    }
}
