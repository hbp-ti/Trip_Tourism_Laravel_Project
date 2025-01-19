<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/login.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/authentication.js'])
</head>

<body>


    <div class="container">

        <div class="language-selector">
            <a href="#" class="language-toggle" id="languageToggle">
                <img src="{{ asset('images/languageSelection1.png') }}" alt="{{ __('messages.Globe') }}"
                    class="language-img" />
                {{ strtoupper(app()->getLocale()) }}
            </a>
            <div class="language-dropdown" id="languageDropdown">
                <!-- Link para alterar para o inglês -->
                <a href="{{ url(preg_replace('#/' . app()->getLocale() . '(/|$)#', '/en$1', request()->getPathInfo())) }}" class="language-option">
                    <img src="{{ asset('images/UK_flag.png') }}" alt="{{ __('English') }}" class="flag-icon" />
                    {{ __('English') }}
                    @if (app()->getLocale() === 'en')
                        <span class="checkmark">✔️</span>
                    @endif
                </a>

                <!-- Link para alterar para o português -->
                <a href="{{ url(preg_replace('#/' . app()->getLocale() . '(/|$)#', '/pt$1', request()->getPathInfo())) }}" class="language-option">
                    <img src="{{ asset('images/PT_flag.png') }}" alt="{{ __('Portuguese') }}" class="flag-icon" />
                    {{ __('Portuguese') }}
                    @if (app()->getLocale() === 'pt')
                        <span class="checkmark">✔️</span>
                    @endif
                </a>
            </div>

        </div>

        <div class="form-section">

            <div class="form-container">
                <div class="centralized-logo">
                    <a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}">TurisGo</a>
                </div>

                <h2>{{ __('messages.Welcome Back!') }}</h2>
                <p class="login">{{ __('messages.Enter your credentials to access your account') }}</p>
                <form class="resetForm" method="POST"
                    action="{{ route('auth.login.attempt', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <label for="email">{{ __('messages.Email/Username') }}</label>
                    <input type="text" id="email_username" name="email_username"
                        placeholder="{{ __('messages.Enter your email or username') }}" required>

                    <label for="password">{{ __('messages.Password') }}</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password"
                            placeholder="{{ __('messages.Enter your password') }}" required>
                        <span class="help-icon"
                            title="{{ __('messages.Password must be at least 8 characters, a number, Uppercase and a special character') }}">?</span>
                    </div>

                    <div class="remember-me">
                        <label class="switch">
                            <input type="checkbox" name="remember" id="remember">
                            <span class="slider"></span>
                        </label>
                        <span class="remember-text">{{ __('messages.Remember') }}</span>
                        <a href="{{ route('auth.forgot.form', ['locale' => app()->getLocale()]) }}"
                            class="forgot-password">{{ __('messages.Forgot password?') }}</a>
                    </div>

                    <button type="submit">{{ __('messages.Login') }}</button>
                </form>
                <p class="account-link">{{ __('messages.Don\'t have an account?') }} <a
                        href="{{ route('auth.register.form', ['locale' => app()->getLocale()]) }}">{{ __('messages.Sign Up') }}
                    </a></p>
            </div>
        </div>
        @if (session('popup'))
            {!! session('popup') !!}
        @endif
        <div class="image-section">
            <div class="image-text">
                <h1>{{ __('messages.TurisGo') }}</h1>
                <p>{{ __('messages.Discover your destination') }}</p>
            </div>
        </div>
    </div>
	<script>
	const appUrl = "{{ config('app.url') }}";
	</script>
</body>

</html>
