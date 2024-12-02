<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TurisGo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/forgotPass.css'])

</head>

<body>

    <div class="container">
        <div class="form-section">
            <div class="form-container">
                <h2>{{ __('messages.Forgot Password?') }}</h2>
                <p class="forgotpass">{{ __('messages.Enter your email address, and we will give you reset instructions') }}</p>
                <form class="forgotForm" action="{{ route('auth.forgot.submit', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <label for="email">{{ __('messages.Email address') }}</label>
                    <input type="email" name="email" id="email" placeholder="{{ __('messages.Enter your email') }}" required>

                    <p class="account-link">{{ __('messages.Remember your password?') }} <a href="{{ route('auth.login.form', ['locale' => app()->getLocale()]) }}">{{ __('messages.Login here') }}</a></p>

                    <button type="submit">{{ __('messages.Forgot Password') }}</button>
                </form>
            </div>
        </div>
        @if(session('popup'))
        {!! session('popup') !!}
        @endif
        <div class="image-section">
            <div class="image-text">
                <h1>{{ __('messages.TurisGo') }}</h1>
                <p>{{ __('messages.Discover your destination') }}</p>
            </div>
        </div>
    </div>

</body>

</html>
