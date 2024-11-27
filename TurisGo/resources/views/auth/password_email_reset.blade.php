<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Hi,</h2>
    <p>We received a request to reset your password. You can reset your password by clicking the link below:</p>
    <p>
        <a href="{{ $resetLink }}">Reset Password</a>
    </p>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thanks,</p>
    <p>The TurisGo Team</p>
</body>
</html>
