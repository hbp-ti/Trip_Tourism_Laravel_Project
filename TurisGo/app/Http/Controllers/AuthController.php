<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
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
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
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

            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'birth_date' => $validatedData['birth_date'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
                'image' => 'images/default_user_image.png',  // Imagem padrão do usuário
            ]);

            $popup = PopupHelper::showPopup(
                'Success!',
                'Your registration was completed successfully. Please log in to continue.',
                'success',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('auth.login.form')->with('popup', $popup);
        } catch (\Exception $e) {
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



    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email_username' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $fieldType = filter_var($validatedData['email_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $validatedData['email_username'],
            'password' => $validatedData['password'],
        ];

        $remember = $request->has('remember');
        
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('homepage');
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
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $popup = PopupHelper::showPopup(
                'Error',
                'No account found with this email.',
                'error',
                'Try Again',
                false,
                '',
                0
            );
            return back()->with('popup', $popup);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = url(route('auth.reset.form', ['token' => $token, 'email' => $request->email], false));

        Mail::to($request->email)->send(new PasswordResetMail($resetLink));

        $popup = PopupHelper::showPopup(
            'Success!',
            'A reset link has been sent to your email.',
            'success',
            'OK',
            false,
            '',
            5000
        );

        return back()->with('popup', $popup);
    }



    public function showResetForm($token, $email)
    {
        $resetRecord = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$resetRecord || $resetRecord->email !== $email) {
            return redirect()->route('auth.login.form')->with('error', 'Token inválido ou expirado');
        }

        session()->flash('reset_token', $token);
        session()->flash('reset_email', $email);

        return view('auth.reset');
    }


    public function resetPassword(Request $request)
    {
        // Validação dos campos
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
            return redirect()->route('auth.login.form')->with('error', 'Invalid or expired token');
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $popup = PopupHelper::showPopup(
            'Success!',
            'Your password has been reset.',
            'success',
            'Continue',
            false,
            '',
            5000
        );

        return redirect()->route('auth.login.form')->with('popup', $popup);
    }

    public function showProfile()
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Not Authorized');
        }
    
        // Obtém o usuário autenticado
        $user = Auth::user();
    
        // Busca as reservas ativas do usuário
        $activeReservations = OrderItem::where('is_active', true)
                                       ->whereHas('order', function ($query) use ($user) {
                                           $query->where('user_id', $user->id);
                                       })
                                       ->get();
    
        // Retorna a view com os dados do usuário e as reservas ativas
        return view('auth.profile', compact('user', 'activeReservations'));
    }
    


    public function editProfile()
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            // Redireciona para a homepage com uma mensagem de erro
            return redirect('/')->with('error', 'Not Authorized');
        }

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Retorna a visão de edição com as informações do usuário
        return view('auth.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            // Redireciona para a homepage com uma mensagem de erro
            return redirect('/')->with('error', 'Not Authorized');
        }

        // Validação das informações do perfil
        $validatedData = $request->validate([
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'username' => 'required|max:20|unique:users,username,' . Auth::id(),
            'phone' => 'required|integer',
            'birth_date' => 'required|date',
        ]);

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Atualiza os dados do usuário
        $user->update($validatedData);

        // Cria um popup de sucesso
        $popup = PopupHelper::showPopup(
            'Profile Updated!',
            'Your profile has been updated successfully.',
            'success',
            'OK',
            false,
            '',
            5000
        );

        // Retorna à página de perfil com o popup de sucesso
        return redirect()->route('auth.profile')->with('popup', $popup);
    }

    // Dentro do AuthController

    public function showCart()
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'Você precisa estar logado para visualizar o carrinho.');
        }

        // Obter o usuário autenticado
        $user = Auth::user();

        // Verificar se o usuário tem um carrinho
        $cart = Cart::where('user_id', $user->id)->first();

        // Se o carrinho não existir, cria um novo
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id, 'subtotal' => 0, 'taxes' => 0, 'total' => 0]);
        }

        // Carregar os itens do carrinho
        $cartItems = $cart->cartItems()->with('item')->get();

        // Calcular subtotal, taxas e total
        $subtotal = $cartItems->sum(function ($item) {
            return $item->item->price * $item->quantity;  // Supondo que cada item tem um preço e quantidade
        });

        $taxes = $subtotal * 0.1;  // Supondo que as taxas são 10%
        $total = $subtotal + $taxes;

        // Atualizar o carrinho com os valores calculados
        $cart->update([
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => $total,
        ]);

        // Retornar a view com os dados do carrinho
        return view('auth.cart', compact('cart', 'cartItems'));
    }

    // Dentro do AuthController

    public function addToCart(Request $request, $itemId)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'Você precisa estar logado para adicionar itens ao carrinho.');
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        // Se o carrinho não existe, cria um novo
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id, 'subtotal' => 0, 'taxes' => 0, 'total' => 0]);
        }

        // Verifica se o item já está no carrinho
        $existingItem = $cart->cartItems()->where('item_id', $itemId)->first();

        if ($existingItem) {
            // Se o item já estiver no carrinho, apenas incrementa a quantidade
            $existingItem->quantity += 1;
            $existingItem->save();
        } else {
            // Caso contrário, cria um novo item no carrinho
            $cart->cartItems()->create([
                'item_id' => $itemId,
                'quantity' => 1,
            ]);
        }

        // Redireciona para a página do carrinho
        return redirect()->route('cart.show');
    }

    // Dentro do AuthController

    public function removeFromCart($cartItemId)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'Você precisa estar logado para remover itens do carrinho.');
        }

        // Encontra o item no carrinho e o remove
        $cartItem = CartItem::find($cartItemId);

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.show');
    }
}
