<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/css/header.css', 'resources/js/jquery-3.7.1.min.js','resources/js/header.js'])

<nav class="navbar">
    <div class="container">
        <a href="/" class="logo">TurisGo</a>

        <div class="nav-links-container">
            <ul class="nav-links">
                <li><a href="{{ route('homepage') }}" class="{{ Route::currentRouteName() == 'homepage' ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('aboutUs') }}" class="{{ Route::currentRouteName() == 'aboutUs' ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('tours') }}" class="{{ Route::currentRouteName() == 'tours' ? 'active' : '' }}">Tours</a></li>
                <li><a href="" class="{{ Route::currentRouteName() == 'hotel' ? 'active' : '' }}">Hotel</a></li>
                <li><a href="{{ route('contact') }}" class="{{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">Contact</a></li>
            </ul>

        </div>

        <div class="nav-actions">
            <div class="language-selector">
                <a href="#" class="language-toggle" id="languageToggle">
                    <img src="{{ asset('images/languageSelection.png') }}" alt="Globe" class="language-img" />
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
            @auth
            <div class="profile-circle">
                <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('images/default_user_image.png') }}" alt="Profile" class="profile-img">
            </div>
            @else
            <a href="{{ route('auth.login.form') }}" class="login-button">Login</a>
            @endauth
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

    </div>
</nav>