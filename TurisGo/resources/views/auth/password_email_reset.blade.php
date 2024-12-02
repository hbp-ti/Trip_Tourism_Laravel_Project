<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ __('Password Reset Request') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
    <h2>{{ __('Hi,') }}</h2>
    <p>{{ __('We received a request to reset your password. You can reset your password by clicking the link below:') }}</p>
    <p>
        <a href="{{ $resetLink }}">{{ __('Reset Password') }}</a>
    </p>
    <p>{{ __('If you did not request a password reset, please ignore this email.') }}</p>
    <p>{{ __('Thanks,') }}</p>
    <p>{{ __('The TurisGo Team') }}</p>
</body>
</html>
