@vite(['resources/css/header.css'])

<nav class="navbar">
    <div class="container">
        <a href="/" class="logo">TurisGo</a>

        <div class="nav-links-container">
            <ul class="nav-links">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route("aboutUs") }}">About</a></li>
                <li><a href="">Tours</a></li>
                <li><a href="">Hotel</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </div>

        <div class="nav-actions">
            <a href="#" class="language">
                <img src="{{ asset('images/language_globe.png') }}" alt="Globe" class="language-img" />
                EN
            </a>
            <a href="{{ route('login')}}" class="login-button">Login</a>
        </div>

    </div>
</nav>
