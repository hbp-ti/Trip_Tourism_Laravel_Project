<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite(['resources/css/profile.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/profile.js'])
</head>
<body>
<x-header/>

<div class="header">
    <img src="{{ asset('images/profile.png') }}" class="profile-pic">
    <div class="header-text">
        <h1 class="header-title">Rodrigo</h1>
        <p class="header-subtitle">Profile</p>
    </div>
</div>

<div class="profile-content">
    <img src="{{ asset('images/fundoprofile.png') }}" class="profile-background">
    
    <div class="profile-info">
        <div class="form-group">
            <label>Name</label>
            <input type="text" value="Rodrigo Fernandes" readonly>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" value="rodrigo" readonly>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" value="rodrigo@exemplo.pt" readonly>
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" value="Rua das Almas 17" readonly>
        </div>
        <div class="form-group">
            <label>Nationality</label>
            <input type="text" value="Portugal" readonly>
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
        <div class="reservation-item">
            <img src="{{ asset('images/condade.png') }}" alt="Hotel Condade">
            <div class="reservation-info">
                <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon"> Hotel Condade</h3>
                <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> August 8th to 12th</p>
                <button class="details-button">Details</button>
                <button class="cancel-button">Cancel</button>
                <button class="download1-button">
                    Download <img src="{{ asset('images/download.png') }}" class="Dicon">
                </button>
            </div>
        </div>
        <div class="reservation-item">
            <img src="{{ asset('images/condade.png') }}" alt="Hotel Estriber">
            <div class="reservation-info">
                <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon"> Hotel Estriber</h3>
                <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> September 10th to 15th</p>
                <button class="details-button">Details</button>
                <button class="cancel-button">Cancel</button>
                <button class="download1-button">
                    Download <img src="{{ asset('images/download.png') }}" class="Dicon">
                </button>
            </div>
        </div>
    </div>

    <div class="reservations history">
        <h2 class="reservations-title">
            History <span class="title-line1"></span>
        </h2>
        <div class="reservation-item">
            <img src="{{ asset('images/atividade.png') }}" alt="Atividade 1">
            <div class="reservation-info">
                <h3><img src="{{ asset('images/iconeatividade.png') }}" class="icon"> Atividade 1</h3>
                <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> August 8th to 12th</p>
                <button class="details-button">Details</button>
                <button class="book-again-button">Book Again</button>
                <button class="download-button">
                    Download <img src="{{ asset('images/download.png') }}" class="Dicon">
                </button>
            </div>
        </div>
        <div class="reservation-item">
            <img src="{{ asset('images/atividade.png') }}" alt="Atividade 2">
            <div class="reservation-info">
                <h3><img src="{{ asset('images/iconeatividade.png') }}" class="icon"> Atividade 2</h3>
                <p><img src="{{ asset('images/datahotel.png') }}" class="icon"> August 10th 2024</p>
                <button class="details-button">Details</button>
                <button class="book-again-button">Book Again</button>
                <button class="download-button">
                    Download <img src="{{ asset('images/download.png') }}" class="Dicon">
                </button>
            </div>
        </div>
    </div>
</div>

<x-footer/>

</body>
</html>
