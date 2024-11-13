<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/login.css'])
</head>
<body>

<div class="container">
    <div class="form-section">
        <div class="form-container">
            <h2>Welcome Back!</h2>
            <p class="login">Enter your credentials to access your account</p>
            <form class="resetForm" action="#">     
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your new password" required>

                <label for="password">Confirm Password</label>
                <input type="password" id="password" placeholder="Enter your password" required>

                <div class="remember-me">
                    <label class="switch">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="slider"></span>
                    </label>
                    <span class="remember-text">Remember</span>
                    <a href="" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit">Login</button>
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