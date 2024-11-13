<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/aboutUs.css'])
</head>
<body>
    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>About</h1>
        <p>Algumas coisas sobre nós</p>
    </section>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="title-line-container">
            <h2>About us</h2>
            <hr class="title-line">
        </div>
        <p class="about-text">Welcome to TurisGo! We are a platform dedicated to making travel planning easier by offering an integrated solution that combines hotel searches, cultural activities, routes and transportation options. We believe that the process of planning a trip should be simple and efficient, allowing travelers to focus on what really matters: enjoying their experience.</p>
        <button class="cta-button">
            <img src="{{ asset('images/map_about.png') }}" alt="Offer Icon"> WHAT WE OFFER
        </button>
    </section>
    <h2 class="titleMiddle">At TurisGo, we provide our users with a platform where they can</h2>
    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="features-grid">
                <div class="feature">
                    <img src="{{ asset('images/lupa_about.png') }}" alt="Search Icon">
                    <p>Search and compare hotels and cultural activities in various destinations</p>
                </div>
                <div class="feature">
                    <img src="{{ asset('images/route_about.png') }}" alt="Itinerary Icon">
                    <p>View automatic itineraries with route and transportation suggestions</p>
                </div>
                <div class="feature">
                    <img src="{{ asset('images/weather_about.png') }}" alt="Weather Icon">
                    <p>Check updated weather forecasts to better plan their trips</p>
                </div>
                <div class="feature">
                    <img src="{{ asset('images/calendar_about.png') }}" alt="Booking Icon">
                    <p>Book accommodations and activities securely and conveniently, all in one place</p>
                </div>
                <div class="feature">
                    <img src="{{ asset('images/megafone_about.png') }}" alt="Promotion Icon">
                    <p>Access exclusive promotional packages with accommodation and activity offers</p>
                </div>
                <div class="feature">
                    <img src="{{ asset('images/lampada_about.png') }}" alt="Personalized Icon">
                    <p>Get personalized suggestions based on their preferences and bookings</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Who TurisGo is For Section -->
    <section class="for-section">
        <h2>Who TurisGo is For</h2>
        <p>TurisGo is designed for all travelers who value convenience and simplicity. Whether you’re planning a weekend getaway or a long adventure abroad, TurisGo is here to streamline and enhance your planning experience. Our goal is to streamline the planning process, helping users save time and make the best choices for their trips.</p>
    </section>

    <x-footer/>
</body>
</html>