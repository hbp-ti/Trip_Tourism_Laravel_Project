<html lang="{{ app()->getLocale() }}">


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/css/header.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/header.js'])

<nav class="navbar">
    <div class="container">
        <a href="{{ route('homepage', ['locale' => app()->getLocale()])}}" class="logo">TurisGo</a>
        <div class="nav-links-container">
            <ul class="nav-links">
                <li><a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}" class="{{ Route::currentRouteName() == 'homepage' ? 'active' : '' }}">{{ __('messages.Home') }}</a></li>
                <li><a href="{{ route('aboutUs', ['locale' => app()->getLocale()]) }}" class="{{ Route::currentRouteName() == 'aboutUs' ? 'active' : '' }}">{{ __('messages.About') }}</a></li>
                <li><a href="{{ route('tours', ['locale' => app()->getLocale()]) }}" class="{{ Route::currentRouteName() == 'tours' ? 'active' : '' }}">{{ __('messages.Tours') }}</a></li>
                <li><a href="{{ route('hotels.index', ['locale' => app()->getLocale()]) }}" class="{{ Route::currentRouteName() == 'hotels' ? 'active' : '' }}">{{ __('messages.Hotel') }}</a></li>
                <li><a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="{{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">{{ __('messages.Contact') }}</a></li>
            </ul>
        </div>


        <div class="nav-actions">
            <div class="language-selector">
                <a href="#" class="language-toggle" id="languageToggle">
                    <img src="{{ asset('images/languageSelection1.png') }}" alt="{{ __('messages.Globe') }}" class="language-img" />
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="language-dropdown" id="languageDropdown">
                    <!-- Link para alterar para o inglês -->
                    <a href="{{ url('/'.(app()->getLocale() === 'en' ? 'pt' : 'en').substr(request()->getRequestUri(), 3)) }}" class="language-option">
                        <img src="{{ asset('images/UK_flag.png') }}" alt="{{ __('English') }}" class="flag-icon" />
                        {{ __('English') }}
                        @if (app()->getLocale() === 'en')
                        <span class="checkmark">✔️</span>
                        @endif
                    </a>

                    <!-- Link para alterar para o português -->
                    <a href="{{ url('/'.(app()->getLocale() === 'pt' ? 'en' : 'pt').substr(request()->getRequestUri(), 3)) }}" class="language-option">
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
                    <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('images/default_user_image.png') }}" alt="{{ __('messages.Profile') }}" class="profile-img">
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-header">
                        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('images/default_user_image.png') }}" alt="{{ __('messages.Profile') }}" class="dropdown-profile-img">
                        <span class="dropdown-username">{{ Auth::user()->first_name }}</span>
                        <a href="">
                            <img src="{{ asset('images/notification_icon.png') }}" alt="{{ __('messages.Notification') }}" class="notification-icon">
                        </a>
                    </div>
                    <ul class="dropdown-options">
                        <li>
                            <a href="{{ route('auth.profile.show', ['locale' => app()->getLocale()]) }}">
                                <img src="{{ asset('images/profile_icon.png') }}" class="icon"> {{ __('messages.Profile') }}
                                <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}">
                                <img src="{{ asset('images/support_icon.png') }}" class="icon"> {{ __('messages.Support') }}
                                <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('auth.cart.show', ['locale' => app()->getLocale()]) }}">
                                <img src="{{ asset('images/cart_icon.png') }}" class="icon"> {{ __('messages.Shopping Cart') }}
                                <img src="{{ asset('images/arrow_right.png') }}" class="arrow">
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('auth.logout', ['locale' => app()->getLocale()]) }}" method="POST" class="dropdown-form">
                                @csrf
                                <button type="submit" class="dropdown-button">
                                    <img src="{{ asset('images/logout_icon.png') }}" class="icon"> {{ __('messages.Logout') }}
                                    <img id="logoutButtonArrow" src="{{ asset('images/arrow_right.png') }}" class="arrow">
                                </button>
                            </form>
                        </li>
                    </ul>

                </div>
            </div>
            @else
            <a href="{{ route('auth.login.form', ['locale' => app()->getLocale()]) }}" class="login-button">{{ __('messages.Login') }}</a>
            @endauth
        </div>
    </div>
</nav>