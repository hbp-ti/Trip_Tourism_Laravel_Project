@vite(['resources/css/header.css', 'resources/js/jquery-3.7.1.min.js','resources/js/header.js'])

<nav class="navbar">
    <div class="container">
        <a href="/" class="logo">TurisGo</a>

        <div class="nav-links-container">
            <ul class="nav-links">
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li><a href="{{ route('aboutUs') }}">About</a></li>
                <li><a href="{{ route('tours') }}">Tours</a></li>
                <li><a href="">Hotel</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

        <div class="nav-actions">
            <div class="language-selector">
                <a href="#" class="language-toggle" id="languageToggle">
                    <img src="{{ asset('images/language_globe.png') }}" alt="Globe" class="language-img" />
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="language-dropdown" id="languageDropdown">
                    <a href="{{ route('language.change', 'en') }}" class="language-option">
                        <img src="{{ asset('images/UK_flag.png') }}" alt="English" class="flag-icon" />
                        English
                        @if (app()->getLocale() === 'en')
                        <span class="checkmark">✔️</span>
                        @endif
                    </a>
                    <a href="{{ route('language.change', 'pt') }}" class="language-option">
                        <img src="{{ asset('images/PT_flag.png') }}" alt="Portuguese" class="flag-icon" />
                        Portuguese
                        @if (app()->getLocale() === 'pt')
                        <span class="checkmark">✔️</span>
                        @endif
                    </a>
                </div>
            </div>
            <a href="{{ route('auth.login.form') }}" class="login-button">Login</a>
        </div>

    </div>
</nav>