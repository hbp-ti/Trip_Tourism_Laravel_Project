<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TurisGo</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/resetPass.css'])
</head>

<body>

    <div class="container">
        <div class="form-section">
            <div class="form-container">
                <h2>Reset Password</h2>
                <p class="resetpass">Enter a new password for {{ session('reset_email') }}</p>

                <form class="resetForm" action="{{ route('auth.reset.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ session('reset_token') }}">
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                    <label for="newpassword">New Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your new password" required>

                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required>

                    <button type="submit">Reset Password</button>
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

    @if(session('popup'))
        {!! session('popup') !!}
    @endif
</body>

</html>
