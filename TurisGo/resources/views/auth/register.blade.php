<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
                <h2>Get Started Now</h2>
                <form method="POST" action="{{ route('auth.register.submit')}}">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>

                    <label for="first-name">First Name</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Enter your first name" required>

                    <label for="last-name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Enter your last name" required>

                    <label for="number">Number</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter your number" required>

                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>

                    <label for="birth_date">Birth date</label>
                    <input type="date" name="birth_date" id="birth_date" placeholder="Enter your birth date" required>

                    <label for="password">Password</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span class="help-icon" title="Password must be at least 8 characters, a number, Uppercase and a special character">?</span>
                    </div>

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" required>

                    <label>
                        <input type="checkbox" required> I agree to the <a href="#" id="terms-link">terms & policies</a>
                    </label>

                    <button type="submit">Register</button>
                </form>

                <p class="account-link">Already have an account? <a href="{{ route("auth.login.form") }}">Click here</a></p>
            </div>
        </div>
        @if(session('popup'))
        {!! session('popup') !!}
        @endif
        <div class="image-section">
            <div class="image-text">
                <h1>TurisGo</h1>
                <p>Discover your destination</p>
            </div>
        </div>
    </div>

</body>

</html>