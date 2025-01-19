<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TurisGo</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/resetPass.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/authentication.js'])
</head>

<body>

    <div class="container">
        <div class="language-selector">
                <a href="#" class="language-toggle" id="languageToggle">
                    <img src="{{ asset('images/languageSelection1.png') }}" alt="{{ __('messages.Globe') }}"
                        class="language-img" />
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="language-dropdown" id="languageDropdown">
                    <!-- Link para alterar para o inglês -->
                    <a href="{{ url('/' . (app()->getLocale() === 'en' ? 'pt' : 'en') . substr(request()->getRequestUri(), 3)) }}"
                        class="language-option">
                        <img src="{{ asset('images/UK_flag.png') }}" alt="{{ __('English') }}" class="flag-icon" />
                        {{ __('English') }}
                        @if (app()->getLocale() === 'en')
                            <span class="checkmark">✔️</span>
                        @endif
                    </a>

                    <!-- Link para alterar para o português -->
                    <a href="{{ url('/' . (app()->getLocale() === 'pt' ? 'en' : 'pt') . substr(request()->getRequestUri(), 3)) }}"
                        class="language-option">
                        <img src="{{ asset('images/PT_flag.png') }}" alt="{{ __('Portuguese') }}" class="flag-icon" />
                        {{ __('Portuguese') }}
                        @if (app()->getLocale() === 'pt')
                            <span class="checkmark">✔️</span>
                        @endif
                    </a>
                </div>

            </div>

        <div class="form-section">
            <div class="form-container">
                <h2>{{ __('messages.Reset Password') }}</h2>
                <p class="resetpass">{{ __('messages.Enter a new password for') }} {{ session('reset_email') }}</p>

                <form class="resetForm" action="{{ route('auth.reset.submit', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ session('reset_token') }}">
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                    <label for="newpassword">{{ __('messages.New Password') }}</label>
                    <input type="password" name="password" id="password" placeholder="{{ __('messages.Enter your new password') }}" required>

                    <label for="confirmpassword">{{ __('messages.Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('messages.Confirm password') }}" required>

                    <button type="submit">{{ __('messages.Reset Password') }}</button>
                </form>
            </div>
        </div>

        <div class="image-section">
            <div class="image-text">
                <h1>TurisGo</h1>
                <p>{{ __('messages.Discover your destination') }}</p>
            </div>
        </div>
    </div>

    @if(session('popup'))
        {!! session('popup') !!}
    @endif
	<script>
	const appUrl = "{{ config('app.url') }}";
	</script>
</body>

</html>
