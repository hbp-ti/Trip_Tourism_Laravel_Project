<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            // Validação dos dados de entrada
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
                    'regex:/[A-Z]/',    // Pelo menos uma letra maiúscula
                    'regex:/[0-9]/',     // Pelo menos um número
                    'regex:/[.\@$!%*?&_-]/',  // Pelo menos um caractere especial
                    'confirmed',   // Verifica se a confirmação de senha corresponde
                ],
            ]);

            // Caso a validação seja bem-sucedida

            // Criação do usuário
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

            // Criação do popup de sucesso
            $popup = PopupHelper::showPopup(
                'Success!',
                'Your registration was completed successfully. Please log in to continue.',
                'success',
                'OK',
                false,
                '',
                5000
            );

            // Redireciona para a página de login com o popup de sucesso
            return redirect()->route('auth.login.form')->with('popup', $popup);
        } catch (\Exception $e) {
            // Em caso de erro, cria um popup de erro
            $popup = PopupHelper::showPopup(
                'Error',
                'An unexpected error occurred. Please check the credentials!',
                'error',
                'OK',
                false,
                '',
                0
            );

            // Retorna à página de registro com o popup de erro
            return back()->with('popup', $popup);
        }
    }



    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $remember = $request->has('remember');
        // Tentativa de login com as credenciais fornecidas
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            return redirect()->route('homepage');
        }

        // Caso o login falhe, cria o popup de erro
        $popup = PopupHelper::showPopup(
            'Login Failed',
            'Invalid email or password. Please try again.',
            'error',
            'Try Again',
            false,
            '',
            0
        );

        // Retorna à página de login com o popup de erro
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

    public function showResetForm($token)
    {
        $resetRecord = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$resetRecord) {
            return redirect()->route('auth.login.form')->with('error', 'Invalid or expired token');
        }

        return view('auth.reset', [
            'token' => $token,
            'email' => $resetRecord->email
        ]);
    }

    public function resetPassword(Request $request)
    {
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
/*
    public function showProfile()
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Obtenha as reservas ativas e o histórico do usuário (você pode personalizar isso conforme necessário)
        $activeReservations = Reservation::where('user_id', $user->id)->where('status', 'active')->get();
        $reservationHistory = Reservation::where('user_id', $user->id)->where('status', 'completed')->get();
 
        // Retorna a view com os dados necessários
        return view('auth.profile', compact('user'));
    }
    

    public function editProfile()
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'Not Authorized');
        }

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Retorna a visão de edição com as informações do usuário
        return view('auth.edit-profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
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
    }*/
}
