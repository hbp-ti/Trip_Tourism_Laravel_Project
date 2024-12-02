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
                <h2>{{ __('messages.Get Started Now') }}</h2>
                <form method="POST" action="{{ route('auth.register.submit', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <label for="first-name">{{ __('messages.First Name') }}</label>
                    <input type="text" name="first_name" id="first_name" placeholder="{{ __('messages.Enter your first name') }}" required>

                    <label for="last-name">{{ __('messages.Last Name') }}</label>
                    <input type="text" name="last_name" id="last_name" placeholder="{{ __('messages.Enter your last name') }}" required>

                    <label for="username">{{ __('messages.Username') }}</label>
                    <input type="text" name="username" id="username" placeholder="{{ __('messages.Enter your username') }}" required>

                    <label for="number">{{ __('messages.Number') }}</label>
                    <input type="text" name="phone" id="phone" placeholder="{{ __('messages.Enter your number') }}" required>

                    <label for="email">{{ __('messages.Email address') }}</label>
                    <input type="email" name="email" id="email" placeholder="{{ __('messages.Enter your email') }}" required>

                    <label for="birth_date">{{ __('messages.Birth date') }}</label>
                    <input type="date" name="birth_date" id="birth_date" placeholder="{{ __('messages.Enter your birth date') }}" required>

                    <label for="password">{{ __('messages.Password') }}</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" placeholder="{{ __('messages.Enter your password') }}" required>
                        <span class="help-icon" title="{{ __('messages.Password must be at least 8 characters, a number, Uppercase and a special character') }}">?</span>
                    </div>

                    <label for="confirm-password">{{ __('messages.Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('messages.Confirm your password') }}" required>

                    <label>
                        <input type="checkbox" required> {{ __('messages.I agree to the') }} <a href="#" id="terms-link">{{ __('messages.terms & policies') }}</a>
                    </label>

                    <button type="submit">{{ __('messages.Register') }}</button>
                </form>

                <p class="account-link">{{ __('messages.Already have an account?') }} <a href="{{ route("auth.login.form", ['locale' => app()->getLocale()]) }}">{{ __('messages.Click here') }}</a></p>
            </div>
        </div>
        @if(session('popup'))
        {!! session('popup') !!}
        @endif
        <div class="image-section">
            <div class="image-text">
                <h1>TurisGo</h1>
                <p>{{ __('messages.Discover your destination') }}</p>
            </div>
        </div>
    </div>

</body>

</html>
