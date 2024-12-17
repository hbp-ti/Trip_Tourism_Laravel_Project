<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- Incluir o SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/profile.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/profile.js'])
</head>

<body>
    <x-header /> <!-- Componente de Cabeçalho -->

    <div class="header">
        <!-- Container do Cabeçalho -->
        <div class="profile-pic-container">
            <img src="{{ asset('images/profile.png') }}" class="profile-pic" alt="Profile Picture">
            <div class="button-overlay">
                <form id="profileForm"
                    action="{{ route('auth.profile.update.picture', ['locale' => app()->getLocale()]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Input de imagem -->
                    <input type="file" name="profile_picture" id="uploadInput" accept="image/*"
                        style="display: none;">
                    <!-- Botão de enviar imagem -->
                    <button type="button" class="edit-profile-pic" id="changeprofilepic">
                        <img src="{{ asset('images/changetour.png') }}" alt="Edit Icon">
                    </button>
                </form>
            </div>

            <input type="file" id="uploadInput" accept="image/*" style="display: none;">
        </div>
        <div class="header-text">
            <h1 class="header-title">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
            <p class="header-subtitle">{{ __('Profile') }}</p>
        </div>
    </div>
    <!-- Conteúdo do Perfil -->
    <div class="profile-content">
        <img src="{{ asset('images/fundoprofile.png') }}" class="profile-background" alt="Profile Background">

        <form class="profile-info" method="POST"
            action="{{ route('auth.profile.update', ['locale' => app()->getLocale()]) }}">
            @csrf
            <div class="form-group">
                <label>{{ __('messages.First Name') }}</label>
                <input type="text" name="first_name" value="{{ Auth::user()->first_name }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Last Name') }}</label>
                <input type="text" name="last_name" value="{{ Auth::user()->last_name }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Username') }}</label>
                <input type="text" name="username" value="{{ Auth::user()->username }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Email') }}</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Phone') }}</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone ?? __('messages.Not provided') }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Submit') }}</label>
                <button id="changeinfoButton" type="submit"
                    class="change-password-btn">{{ __('messages.Submit Changes') }}</button>
            </div>
        </form>
        @if(session('popup'))
        {!! session('popup') !!}
        @endif
        <div class="form-group">
            <label>{{ __('messages.Change Password') }}</label>
            <button id="changePasswordButton"
                type="button"class="change-password-btn">{{ __('messages.Change Password') }}</button>
        </div>
        <!-- Popup de Mudança de Password -->
        <div id="passwordPopup" class="popup hidden">
            <div class="popup-content">
                <h2>{{ __('messages.Change Password') }}</h2>

                <form id="changePasswordForm" method="POST"
                    action="{{ route('auth.profile.updatePassword', ['locale' => app()->getlocale()]) }}">
                    @csrf
                    <!-- Campo para senha antiga -->
                    <div class="form-group">
                        <label for="oldPassword">{{ __('messages.Current Password') }}</label>
                        <input type="password" id="oldPassword" name="oldPassword"
                            placeholder="{{ __('messages.Enter last password') }}" required>
                    </div>

                    <!-- Campo para nova senha -->
                    <div class="form-group">
                        <label for="newPassword">{{ __('messages.New Password') }}</label>
                        <input type="password" id="newPassword" name="newPassword"
                            placeholder="{{ __('messages.Enter new password') }}" required>
                    </div>

                    <!-- Campo para confirmação da nova senha -->
                    <div class="form-group">
                        <label for="confirmPassword">{{ __('messages.Confirm New Password') }}</label>
                        <input type="password" id="confirmPassword" name="newPassword_confirmation"
                            placeholder="{{ __('messages.Confirm new password') }}" required>
                    </div>

                    <!-- Botões -->
                    <div class="popup-buttons">
                        <button type="button" id="cancelChangePassword" class="cancel-btn">Cancel</button>
                        <button type="submit" id="confirmChangePassword" class="confirm-btn">Confirm</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Reservas Ativas -->
        <div class="reservations active-reservations">
            <h2 class="reservations-title">
                {{ __('messages.Active Reservations') }} <span class="title-line"></span>
            </h2>
            <!-- Exibir reservas ativas -->
            @if ($activeReservations->isEmpty())
                <p>{{ __('messages.No active reservations at the moment.') }}</p>
            @else
                @foreach ($activeReservations as $reservation)
                    <div class="reservation-item">
                        <img src="{{ asset('images/' . $reservation->hotel_image) }}"
                            alt="{{ $reservation->hotel_name }}">
                        <div class="reservation-info">
                            <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                {{ $reservation->hotel_name }}</h3>
                            <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                {{ $reservation->reservation_date_hotel }}</p>
                            <button class="details-button">{{ __('messages.Details') }}</button>
                            <button class="cancel-button">{{ __('messages.Cancel') }}</button>
                            <button class="download1-button">
                                {{ __('messages.Download') }} <img src="{{ asset('images/download.png') }}"
                                    class="Dicon">
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Histórico de Reservas -->
        <div class="reservations history">
            <h2 class="reservations-title">
                {{ __('messages.Reservation History') }} <span class="title-line1"></span>
            </h2>
            <!-- Exibir histórico de reservas -->
            @if ($expiredReservations->isEmpty())
                <p>{{ __('messages.No past reservations available.') }}</p>
            @else
                @foreach ($expiredReservations as $history)
                    <div class="reservation-item">
                        <img src="{{ asset('images/' . $history->activity_image) }}"
                            alt="{{ $history->activity_name }}">
                        <div class="reservation-info">
                            <h3><img src="{{ asset('images/iconeatividade.png') }}" class="icon">
                                {{ $history->activity_name }}</h3>
                            <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                {{ $history->reservation_date }}</p>
                            <button class="details-button">{{ __('messages.Details') }}</button>
                            <button class="book-again-button">{{ __('messages.Book Again') }}</button>
                            <button class="download-button">
                                {{ __('messages.Download') }} <img src="{{ asset('images/download.png') }}"
                                    class="Dicon">
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
