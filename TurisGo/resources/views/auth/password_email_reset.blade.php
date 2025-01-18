<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ __('messages.Password Reset Request') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
    <h2>{{ __('messages.Hi,') }}</h2>
    <p>{{ __('messages.We received a request to reset your password. You can reset your password by clicking the link below:') }}</p>
    <p>
        <a href="{{ $resetLink }}">{{ __('messages.Reset Password') }}</a>
    </p>
    <p>{{ __('messages.If you did not request a password reset, please ignore this email.') }}</p>
    <p>{{ __('messages.Thanks,') }}</p>
    <p>{{ __('messages.The TurisGo Team') }}</p>
	<script>
	const appUrl = "{{ config('app.url') }}";
	</script>
</body>
</html>
