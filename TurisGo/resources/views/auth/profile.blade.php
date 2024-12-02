<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/profile.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/profile.js'])
</head>

<body>
    <x-header /> <!-- Componente de Cabeçalho -->

    <!-- Cabeçalho da Página de Perfil -->
    <div class="header">
        <img src="{{ asset('images/profile.png') }}" class="profile-pic" alt="Profile Picture">
        <div class="header-text">
            <h1 class="header-title">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
            <p class="header-subtitle">{{ __('Profile') }}</p>
        </div>
    </div>

    <!-- Conteúdo do Perfil -->
    <div class="profile-content">
        <img src="{{ asset('images/fundoprofile.png') }}" class="profile-background" alt="Profile Background">

        <div class="profile-info">
            <!-- Exibição de Informações do Usuário -->
            <div class="form-group">
                <label>{{ __('First Name') }}</label>
                <input type="text" value="{{ Auth::user()->first_name }}" readonly>
            </div>
            <div class="form-group">
                <label>{{ __('Last Name') }}</label>
                <input type="text" value="{{ Auth::user()->last_name }}" readonly>
            </div>
            <div class="form-group">
                <label>{{ __('Username') }}</label>
                <input type="text" value="{{ Auth::user()->username }}" readonly>
            </div>
            <div class="form-group">
                <label>{{ __('Email') }}</label>
                <input type="email" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="form-group">
                <label>{{ __('Address') }}</label>
                <input type="text" value="{{ Auth::user()->address ?? __('Not provided') }}" readonly>
            </div>
            <div class="form-group">
                <label>{{ __('Password') }}</label>
                <input type="password" value="********" readonly>
            </div>
        </div>

        <!-- Botão de Edição do Perfil -->
        <a id="editButton" class="edit-button">{{ __('Edit') }}</a>

        <!-- Reservas Ativas -->
        <div class="reservations active-reservations">
            <h2 class="reservations-title">
                {{ __('Active Reservations') }} <span class="title-line"></span>
            </h2>
            <!-- Exibir reservas ativas -->
            @if($activeReservations->isEmpty())
            <p>{{ __('No active reservations at the moment.') }}</p>
            @else
            @foreach ($activeReservations as $reservation)
            <div class="reservation-item">
                <img src="{{ asset('images/' . $reservation->hotel_image) }}" alt="{{ $reservation->hotel_name }}">
                <div class="reservation-info">
                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon"> {{ $reservation->hotel_name }}</h3>
                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> {{ $reservation->reservation_date_hotel }}</p>
                    <button class="details-button">{{ __('Details') }}</button>
                    <button class="cancel-button">{{ __('Cancel') }}</button>
                    <button class="download1-button">
                        {{ __('Download') }} <img src="{{ asset('images/download.png') }}" class="Dicon">
                    </button>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <!-- Histórico de Reservas -->
        <div class="reservations history">
            <h2 class="reservations-title">
                {{ __('Reservation History') }} <span class="title-line1"></span>
            </h2>
            <!-- Exibir histórico de reservas -->
            @if($expiredReservations->isEmpty())
            <p>{{ __('No past reservations available.') }}</p>
            @else
            @foreach ($expiredReservations as $history)
            <div class="reservation-item">
                <img src="{{ asset('images/' . $history->activity_image) }}" alt="{{ $history->activity_name }}">
                <div class="reservation-info">
                    <h3><img src="{{ asset('images/iconeatividade.png') }}" class="icon"> {{ $history->activity_name }}</h3>
                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> {{ $history->reservation_date }}</p>
                    <button class="details-button">{{ __('Details') }}</button>
                    <button class="book-again-button">{{ __('Book Again') }}</button>
                    <button class="download-button">
                        {{ __('Download') }} <img src="{{ asset('images/download.png') }}" class="Dicon">
                    </button>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <x-footer /> <!-- Componente de Rodapé -->
</body>

</html>
