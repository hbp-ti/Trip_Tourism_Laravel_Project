<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/login.css'])
</head>

<body>

    <div class="container">
        <div class="form-section">
            <div class="form-container">
                <h2>{{ __('Welcome Back!') }}</h2>
                <p class="login">{{ __('Enter your credentials to access your account') }}</p>
                <form class="resetForm" method="POST" action="{{ route('auth.login.attempt') }}">
                    @csrf
                    <label for="email">{{ __('Email/Username') }}</label>
                    <input type="text" id="email_username" name="email_username" placeholder="{{ __('Enter your email or username') }}" required>

                    <label for="password">{{ __('Password') }}</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" placeholder="{{ __('Enter your password') }}" required>
                        <span class="help-icon" title="{{ __('Password must be at least 8 characters, a number, Uppercase and a special character') }}">?</span>
                    </div>

                    <div class="remember-me">
                        <label class="switch">
                            <input type="checkbox" name="remember" id="remember">
                            <span class="slider"></span>
                        </label>
                        <span class="remember-text">{{ __('Remember') }}</span>
                        <a href="{{ route('auth.forgot.form') }}" class="forgot-password">{{ __('Forgot password?') }}</a>
                    </div>

                    <button type="submit">{{ __('Login') }}</button>
                </form>
                <p class="account-link">{{ __("Don't have an account?") }} <a href="{{ route('auth.register.form') }}">{{ __('Sign Up') }}</a></p>
            </div>
        </div>
        @if(session('popup'))
        {!! session('popup') !!}
        @endif
        <div class="image-section">
            <div class="image-text">
                <h1>{{ __('TurisGo') }}</h1>
                <p>{{ __('Discover your destination') }}</p>
            </div>
        </div>
    </div>

</body>

</html>
