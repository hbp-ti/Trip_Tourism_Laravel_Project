<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite(['resources/css/profile.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/profile.js'])
</head>

<body>
    <x-header />

    <div class="header">
        <img src="{{ asset('images/profile.png') }}" class="profile-pic" alt="Profile Picture">
        <div class="header-text">
            <h1 class="header-title">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
            <p class="header-subtitle">Profile</p>
        </div>
    </div>

    <div class="profile-content">
        <img src="{{ asset('images/fundoprofile.png') }}" class="profile-background" alt="Profile Background">

        <div class="profile-info">
            <div class="form-group">
                <label>Name</label>
                <input type="text" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" readonly>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" value="{{ Auth::user()->username }}" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" value="{{ Auth::user()->address }}" readonly>
            </div>
            <div class="form-group">
                <label>Nationality</label>
                <input type="text" value="{{ Auth::user()->nationality }}" readonly>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" value="********" readonly>
            </div>
        </div>

        <button type="button" class="edit-button">Edit</button>

        <div class="reservations active-reservations">
            <h2 class="reservations-title">
                Active Reservations <span class="title-line"></span>
            </h2>
            <!--
            @foreach ($activeReservations as $reservation)
                <div class="reservation-item">
                    <img src="{{ asset('images/' . $reservation->hotel_image) }}" alt="{{ $reservation->hotel_name }}">
                    <div class="reservation-info">
                        <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon"> {{ $reservation->hotel_name }}</h3>
                        <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> {{ $reservation->dates }}</p>
                        <button class="details-button">Details</button>
                        <button class="cancel-button">Cancel</button>
                        <button class="download1-button">
                            Download <img src="{{ asset('images/download.png') }}" class="Dicon">
                        </button>
                    </div>
                </div>
            @endforeach
            -->
        </div>

        <div class="reservations history">
            <h2 class="reservations-title">
                History <span class="title-line1"></span>
            </h2>
            <!--
            @foreach ($reservationHistory as $history)
                <div class="reservation-item">
                    <img src="{{ asset('images/' . $history->activity_image) }}" alt="Activity">
                    <div class="reservation-info">
                        <h3><img src="{{ asset('images/iconeatividade.png') }}" class="icon"> {{ $history->activity_name }}</h3>
                        <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> {{ $history->dates }}</p>
                        <button class="details-button">Details</button>
                        <button class="book-again-button">Book Again</button>
                        <button class="download-button">
                            Download <img src="{{ asset('images/download.png') }}" class="Dicon">
                        </button>
                    </div>
                </div>
            @endforeach
                        -->
        </div>
    </div>

    <x-footer />
</body>

</html>