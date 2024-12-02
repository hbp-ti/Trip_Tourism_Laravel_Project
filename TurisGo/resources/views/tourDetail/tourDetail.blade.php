<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/tourDetail.css', 'resources/js/tourDetail.js'])
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
</head>

<body>
    <x-header />

    <!-- Hero Section -->
    <div class="header">
        <h1>{{ __('Tour Details') }}</h1>
        <p>{{ __('Some details about your reservation') }}</p>
    </div>

    <!-- Tour Content Section -->
    <div class="tour-details">
        <h2>{{ __('Parque Jump') }}</h2>
        <p>{{ __('Explore the beautiful Albufeira coastline, visiting hidden spots and the famous Benagil cave. Swim and spot dolphins along the way (weather permitting) as you enjoy this tour. With a blend of adventure, nature, and relaxing, this tour offers the perfect mix for a day well spent with friends or family. Book today with a simple, quick, and secure booking to bypass the queues and kickstart an unforgettable adventure with memories to keep.') }}</p>

        <!-- Image Slider -->
        <div class="image-slider">
            <img src="{{ asset('images/tourDetailsJump.png') }}" alt="{{ __('Parque Jump') }}">
        </div>

        <!-- Direction Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('Direction') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
        </div>
        <div id="map"></div>
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31255.612595920426!2d-8.4463744!3d40.574588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22ebf03068b2b3%3A0x833c2e505b1b476c!2s%C3%81gueda%2C%20Portugal!5e0!3m2!1sen!2spt!4v1696420912345!5m2!1sen!2spt"
                width="100%"
                height="550px"
                style="border:8px;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="button-group">
            <button class="btn btn-primary">{{ __('Open') }}</button>
            <button class="btn btn-secondary">{{ __('Download') }}</button>
        </div>

        <!-- Weather Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('Weather') }}</h3>
            <hr class="section-divider" style="background-color: #2081A5;">
        </div>
        <div id="weather">
            <iframe width="100%" height="400" src="https://embed.windy.com/embed2.html?lat=38.7223&lon=-9.1393&detailLat=38.7223&detailLon=-9.1393&width=650&height=450&zoom=10&level=surface&overlay=rain&product=ecmwf&menu=&message=&marker=&calendar=&pressure=&type=map&location=coordinates&detail=&metricWind=default&metricTemp=default&radarRange=-1" frameborder="0" allowfullscreen></iframe>
        </div>

        <!-- Train/Bus Tickets Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('Train/Bus Tickets') }}</h3>
            <hr class="section-divider" style="background-color: #2081A5;">
        </div>
        <p style="text-align: center; font-size: 1.7rem; margin-bottom: 20px;">{{ __('Seems like you didn\'t buy train/bus tickets!') }}</p>
        <div class="button-group">
            <button class="btn btn-primary" style="background-color: #2081A5;">{{ __('Buy Train Tickets') }}</button>
            <button class="btn btn-primary" style="background-color: #2081A5;">{{ __('Buy Bus Tickets') }}</button>
        </div>
    </div>

    <x-footer />
</body>

</html>
