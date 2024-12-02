<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TurisGo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/register.css', 'resources/css/terms.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/terms.js'])
    @include('auth.terms')
</head>

<body>

    <div class="container">
        <div class="form-section">
            <div class="form-container">
                <h2>{{ __('Get Started Now') }}</h2>
                <form method="POST" action="{{ route('auth.register.submit') }}">
                    @csrf
                    <label for="first-name">{{ __('First Name') }}</label>
                    <input type="text" name="first_name" id="first_name" placeholder="{{ __('Enter your first name') }}" required>

                    <label for="last-name">{{ __('Last Name') }}</label>
                    <input type="text" name="last_name" id="last_name" placeholder="{{ __('Enter your last name') }}" required>

                    <label for="username">{{ __('Username') }}</label>
                    <input type="text" name="username" id="username" placeholder="{{ __('Enter your username') }}" required>

                    <label for="number">{{ __('Number') }}</label>
                    <input type="text" name="phone" id="phone" placeholder="{{ __('Enter your number') }}" required>

                    <label for="email">{{ __('Email address') }}</label>
                    <input type="email" name="email" id="email" placeholder="{{ __('Enter your email') }}" required>

                    <label for="birth_date">{{ __('Birth date') }}</label>
                    <input type="date" name="birth_date" id="birth_date" placeholder="{{ __('Enter your birth date') }}" required>

                    <label for="password">{{ __('Password') }}</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" placeholder="{{ __('Enter your password') }}" required>
                        <span class="help-icon" title="{{ __('Password must be at least 8 characters, a number, Uppercase and a special character') }}">?</span>
                    </div>

                    <label for="confirm-password">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirm your password') }}" required>

                    <label>
                        <input type="checkbox" required> {{ __('I agree to the') }} <a href="#" id="terms-link">{{ __('terms & policies') }}</a>
                    </label>

                    <button type="submit">{{ __('Register') }}</button>
                </form>

                <p class="account-link">{{ __('Already have an account?') }} <a href="{{ route("auth.login.form") }}">{{ __('Click here') }}</a></p>
            </div>
        </div>
        @if(session('popup'))
        {!! session('popup') !!}
        @endif
        <div class="image-section">
            <div class="image-text">
                <h1>TurisGo</h1>
                <p>{{ __('Discover your destination') }}</p>
            </div>
        </div>
    </div>

</body>

</html>
