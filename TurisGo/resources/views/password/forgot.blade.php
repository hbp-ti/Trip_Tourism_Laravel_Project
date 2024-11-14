<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TurisGo</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/forgotPass.css'])

</head>
<body>

<div class="container">
    <div class="form-section">
        <div class="form-container">
            <h2>Forgot Password?</h2>
            <p class="forgotpass">Enter your email address, and we will give you reset instructions</p>
            <form class="forgotForm" action="#">     
                <label for="email">Email address</label>
                <input type="email" id="email" placeholder="Enter your email" required>

                <p class="account-link">Remember your password? <a href="{{ route('login') }}">Login here</a></p>

                <button type="submit">Forgot Password</button>
            </form>
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