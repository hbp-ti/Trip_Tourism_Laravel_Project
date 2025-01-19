<html lang="{{ app()->getLocale() }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/css/header.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/header.js'])

<nav class="navbar">
    <div class="container">
        <a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}" class="logo">TurisGo</a>
        <div class="nav-links-container">
            <ul class="nav-links">
                <li><a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}"
                        class="{{ Route::currentRouteName() == 'homepage' ? 'active' : '' }}">{{ __('messages.Home') }}</a>
                </li>
                <li><a href="{{ route('aboutUs', ['locale' => app()->getLocale()]) }}"
                        class="{{ Route::currentRouteName() == 'aboutUs' ? 'active' : '' }}">{{ __('messages.About') }}</a>
                </li>
                <li><a href="{{ route('tours', ['locale' => app()->getLocale()]) }}"
                        class="{{ Route::currentRouteName() == 'tours' ? 'active' : '' }}">{{ __('messages.Tours') }}</a>
                </li>
                <li><a href="{{ route('hotels', ['locale' => app()->getLocale()]) }}"
                        class="{{ Route::currentRouteName() == 'hotels' ? 'active' : '' }}">{{ __('messages.Hotel') }}</a>
                </li>
                <li><a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                        class="{{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">{{ __('messages.Contact') }}</a>
                </li>
            </ul>
        </div>


        <div class="nav-actions">
            <div class="language-selector">
                <a href="#" class="language-toggle" id="languageToggle">
                    <img src="{{ asset('images/languageSelection1.png') }}" alt="{{ __('messages.Globe') }}"
                        class="language-img" />
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="language-dropdown" id="languageDropdown">
                    <!-- Link para alterar para o inglês -->
                    <a href="{{ url(preg_replace('#/' . app()->getLocale() . '(/|$)#', '/en$1', request()->getPathInfo())) }}" class="language-option">
                        <img src="{{ asset('images/UK_flag.png') }}" alt="{{ __('English') }}" class="flag-icon" />
                        {{ __('English') }}
                        @if (app()->getLocale() === 'en')
                            <span class="checkmark">✔️</span>
                        @endif
                    </a>

                    <!-- Link para alterar para o português -->
                    <a href="{{ url(preg_replace('#/' . app()->getLocale() . '(/|$)#', '/pt$1', request()->getPathInfo())) }}" class="language-option">
                        <img src="{{ asset('images/PT_flag.png') }}" alt="{{ __('Portuguese') }}" class="flag-icon" />
                        {{ __('Portuguese') }}
                        @if (app()->getLocale() === 'pt')
                            <span class="checkmark">✔️</span>
                        @endif
                    </a>
                </div>

            </div>

            @auth
                <div class="profile-dropdown">
                    <div class="profile-circle">
                        <img src="{{ file_exists(public_path('storage/' . Auth::user()->image)) ? asset('storage/' . Auth::user()->image) : asset('images/default_user_image.png') }}"
                            alt="{{ __('messages.Profile') }}" class="profile-img">
                    </div>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">
                            <img src="{{ file_exists(public_path('storage/' . Auth::user()->image)) ? asset('storage/' . Auth::user()->image) : asset('images/default_user_image.png') }}"
                                alt="{{ __('messages.Profile') }}" class="dropdown-profile-img">
                            <span class="dropdown-username">{{ Auth::user()->first_name }}</span>
                            <a href="javascript:void(0);" id="notificationButton">
                                <img src="{{ asset('images/notification_icon.png') }}"
                                    alt="{{ __('messages.Notification') }}" class="notification-icon">
                            </a>
                        </div>
                        <ul class="dropdown-options">
                            <li>
                                <a href="{{ route('auth.profile.show', ['locale' => app()->getLocale()]) }}">
                                    <img src="{{ asset('images/profile_icon.png') }}" class="icon">
                                    {{ __('messages.Profile') }}
                                    <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}">
                                    <img src="{{ asset('images/support_icon.png') }}" class="icon">
                                    {{ __('messages.Support') }}
                                    <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('auth.cart.show', ['locale' => app()->getLocale()]) }}">
                                    <img src="{{ asset('images/cart_icon.png') }}" class="icon">
                                    {{ __('messages.Shopping Cart') }}
                                    <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                                </a>
                            </li>
                            @if (Auth::user()->is_admin)
                            <li>
                                <a href="{{ route('auth.admin.dashboard', ['locale' => app()->getLocale()]) }}">
                                    <img src="{{ asset('images/dashboard_icon.png') }}" class="icon">
                                    {{ __('messages.Dashboard') }}
                                    <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                                </a>
                            </li>
                            @endif
                            <li>
                                <form action="{{ route('auth.logout', ['locale' => app()->getLocale()]) }}" method="POST"
                                    class="dropdown-form">
                                    @csrf
                                    <button type="submit" class="dropdown-button">
                                        <img src="{{ asset('images/logout_icon.png') }}" class="icon">
                                        {{ __('messages.Logout') }}
                                        <img id="logoutButtonArrow" src="{{ asset('images/arrow_right.png') }}"
                                            class="arrow">
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            @else
                <a href="{{ route('auth.login.form', ['locale' => app()->getLocale()]) }}"
                    class="login-button">{{ __('messages.Login') }}</a>
            @endauth
        </div>
    </div>
    <div class="toast-container">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <span class="notification-bell">&#x1F514;</span>
                <strong class="toast-title">{{ __('messages.Notifications') }}</strong>
                <span id="trash-icon" class="trash-icon">&#x1F5D1;</span>
                <button type="button" class="close-toast" aria-label="Close">&#10006;</button>
            </div>
            <div class="toast-body">
                <div class="toast-accordion" id="toast-accordion">
                    <!-- As notificações serão carregadas aqui via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    </div>

</nav>
