<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Room;
use App\Models\OrderItem;
use App\Models\Order;
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

        if (!$user) {
            $popup = PopupHelper::showPopup('Error', 'No account found with this email.', 'error', 'Try Again', false, '', 0);
            return back()->with('popup', $popup);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(['email' => $request->email], ['token' => $token, 'created_at' => now()]);
        $resetLink = url(route('auth.reset.form', ['locale' => $locale, 'token' => $token, 'email' => $request->email], false));

        Mail::to($request->email)->send(new PasswordResetMail($resetLink));

        $popup = PopupHelper::showPopup('Success!', 'A reset link has been sent to your email.', 'success', 'OK', false, '', 5000);
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

        $activeReservations = OrderItem::where('is_active', true)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        $expiredReservations = OrderItem::where('is_active', false)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return view('auth.profile', compact('user', 'activeReservations', 'expiredReservations', 'locale'));
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
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Você precisa estar logado para visualizar o carrinho.');
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id], ['subtotal' => 0, 'taxes' => 0, 'total' => 0]);

        $cartItems = $cart->cartItems()->with('item')->get();

        $subtotal = $cartItems->sum(fn($item) => $item->item->price * $item->quantity);
        $taxes = $subtotal * 0.1;  // Taxas de 10%
        $total = $subtotal + $taxes;

        $cart->update([
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => $total,
        ]);

        return view('auth.cart', compact('cart', 'cartItems', 'locale'));
    }

    public function addToCart(Request $request)
    {
        $locale = $request->route('locale');
        $popupError = PopupHelper::showPopup(
            'Authentication!',
            'You must be logged in to add items to the cart',
            'Error',
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

        // Recuperar dados da requisição
        $roomId = $request->input('room_id');
        $room = Room::findOrFail($roomId); // Buscar o quarto específico

        $checkinDate = $request->input('checkin_date.' . $roomId);
        $checkoutDate = $request->input('checkout_date.' . $roomId);
        $guestsCount = $request->input('guests.' . $roomId);
        $itemHash = $request->input('item_hash.' . $roomId);

        // Gerar o hash correto para o room_id
        $dataToHash = $room->id . '|' . $room->price_night;
        $expectedHash = hash_hmac('sha256', $dataToHash, config('app.key'));

        // Verificar se o hash enviado é válido
        if ($expectedHash !== $itemHash) {
            $popupError2 = PopupHelper::showPopup(
                'Error!',
                'The ids do not match.',
                'Error',
                'OK',
                false,
                '',
                5000
            );
            return back()->with('popup', $popupError2);
        }

        // Adicionar item ao carrinho
        $user = Auth::user();

        // Criar ou obter o carrinho com os valores de subtotal, taxas e total
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id]
        );

        // Identificar o tipo do item a partir do banco de dados
        $itemId = $request->route('itemId');
        $item = Item::findOrFail($itemId);

        // Preparar dados para criar o item no carrinho
        $data = [
            'item_id' => $itemId,
            'cart_id' => $cart->id,
        ];

        // Lógica para tipo "Hotel"
        if ($item->item_type === 'Hotel') {
            $data['numb_people_hotel'] = $guestsCount;  // Pegando o número de pessoas do quarto específico
            $data['room_type_hotel'] = $room->type;  // Usando o tipo do quarto diretamente da variável $room
            $data['reservation_date_hotel_checkin'] = $checkinDate;  // Data de check-in
            $data['reservation_date_hotel_checkout'] = $checkoutDate;  // Data de check-out

            // Definir os outros campos como null
            $data['numb_people_activity'] = null;
            $data['hours_activity'] = null;
            $data['train_type'] = null;
            $data['train_people_count'] = null;

            // Calcular a diferença de dias entre check-in e check-out
            $checkin = \Carbon\Carbon::parse($checkinDate);
            $checkout = \Carbon\Carbon::parse($checkoutDate);
            $daysDifference = $checkin->diffInDays($checkout);

            // Calcular o subtotal (preço do quarto * número de dias * número de pessoas)
            $itemSubtotal = $room->price_night * $daysDifference * $guestsCount;

            // Definir as taxas (exemplo: uma taxa fixa de 4)
            $taxes = 4; // Taxa fixa, você pode ajustar conforme necessário

            // Calcular o total (subtotal + taxas)
            $itemTotal = $itemSubtotal + $taxes;
        }

        // Lógica para tipo "Activity"
        if ($item->item_type === 'Activity') {
            $data['numb_people_activity'] = $request->input('numb_people_activity.' . $itemId);
            $data['hours_activity'] = $request->input('hours_activity.' . $itemId);

            // Definir os outros campos como null
            $data['numb_people_hotel'] = null;
            $data['room_type_hotel'] = null;
            $data['reservation_date_hotel_checkin'] = null;
            $data['reservation_date_hotel_checkout'] = null;
            $data['train_type'] = null;
            $data['train_people_count'] = null;
        }

        // Lógica para tipo "Ticket"
        if ($item->item_type === 'Ticket') {
            $data['train_type'] = $request->input('train_type.' . $itemId);
            $data['train_people_count'] = $request->input('train_people_count.' . $itemId);

            // Definir os outros campos como null
            $data['numb_people_hotel'] = null;
            $data['room_type_hotel'] = null;
            $data['reservation_date_hotel_checkin'] = null;
            $data['reservation_date_hotel_checkout'] = null;
            $data['numb_people_activity'] = null;
            $data['hours_activity'] = null;
        }

        // Criar o item no carrinho
        $cart->cartItems()->create($data);

        // Somar os valores do novo item com os existentes no carrinho
        $newSubtotal = $cart->subtotal + $itemSubtotal;
        $newTaxes = $cart->taxes + $taxes;
        $newTotal = $cart->total + $itemTotal;

        // Atualizar os valores do carrinho com a soma
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

        // Redirecionar para a página do carrinho
        return back()->with('popup', $popupSuccess);
    }




    public function removeFromCart(Request $request, $cartItemId)
    {
        $locale = $request->route('locale');

        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Você precisa estar logado para remover itens do carrinho.');
        }

        $cartItem = CartItem::find($cartItemId);

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.show', ['locale' => $locale]);
    }
}
