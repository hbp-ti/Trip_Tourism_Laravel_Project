<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TurisGo</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/register.css', 'resources/css/terms.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/terms.js'])
    @include('register.terms')
</head>

<body>

    <div class="container">
        <div class="form-section">
            <div class="form-container">
                <h2>Get Started Now</h2>
                <form action="#">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Enter your username" required>

                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" placeholder="Enter your first name" required>

                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" placeholder="Enter your last name" required>

                    <label for="number">Number</label>
                    <input type="text" id="number" placeholder="Enter your number" required>

                    <label for="email">Email address</label>
                    <input type="email" id="email" placeholder="Enter your email" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Enter your password" required>

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" placeholder="Confirm your password" required>

                    <label>
                        <input type="checkbox" required> I agree to the <a href="#" id="terms-link">terms & policies</a>
                    </label>

                    <button type="submit">Register</button>
                </form>
                <p class="account-link">Already have an account? <a href="{{ route("login") }}">Click here</a></p>
            </div>
        </div>

        <div class="image-section">
            <div class="image-text">
                <h1>TurisGo</h1>
                <p>Discover your destination</p>
            </div>
        </div>
    </div>

</body>

</html>