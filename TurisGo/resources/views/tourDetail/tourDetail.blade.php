<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <!-- css e script  de mapa interativo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite(['resources/css/tourDetail.css', 'resources/js/tourDetail.js', 'resources/js/mapa.js'])
</head>

<body>
    <x-header />

    <!-- Hero Section -->
    <div class="header">
        <h1>{{ __('messages.Tour Details') }}</h1>
        <p>{{ __('messages.Some details about your reservation') }}</p>
    </div>

    <!-- Tour Content Section -->
    <div class="tour-details">
        <h2>{{ __('messages.Parque Jump') }}</h2>
        <p class="tour-details-text">{{ __('messages.Explore the beautiful Albufeira coastline, visiting hidden spots and the famous Benagil cave. Swim and spot dolphins along the way (weather permitting) as you enjoy this tour. With a blend of adventure, nature, and relaxing, this tour offers the perfect mix for a day well spent with friends or family. Book today with a simple, quick, and secure booking to bypass the queues and kickstart an unforgettable adventure with memories to keep.') }}</p>

        <!-- Image Slider -->
        <div class="image-slider">
            <img src="{{ asset('images/tourDetailsJump.png') }}" alt="{{ __('messages.Parque Jump') }}">
        </div>

        <!-- Direction Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Direction') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
        </div>

        <!-- Mapa Interativo -->
        <div id="map"></div>

        <div class="button-group">
            <button class="btn btn-primary">{{ __('messages.Open') }}</button>
            <button class="btn btn-secondary">{{ __('messages.Download') }}</button>
        </div>

        <!-- Weather Section -->

        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Weather') }}</h3>
            <hr class="section-divider" style="background-color: #2081A5;">
        </div>
        <div class="weather-section">
            <div class="weather-card-today">
                <div class="weather-head-today">
                    <h5>{{ __('Monday') }}</h4>
                    <h6>{{ __('6 Oct') }}</h6>
                </div>
                <div class="weather-content">
                    <h2>Lisboa</h2>
                    <div class="temp-today">
                        <h1 class="temp">23ºC</h1>
                        <img src="{{ asset('images/weatherPartlyCloudy.png') }}" alt="Partly Cloudy">
                    </div>
                    <div class="weather-status">
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconRain.png') }}" alt="Rain">
                            <h6>20%</h6>
                        </div>
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconWind.png') }}" alt="Wind">
                            <h6>18km/h</h6>
                        </div>
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconWindDirection.png') }}" alt="Wind Direction">
                            <h6>East</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Tuesday') }}</h4>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherRaining.png') }}" alt="Raining">
                    <h3>23ºC</h3>
                    <h6>68%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Wednesday') }}</h4>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherLightning.png') }}" alt="Lightning">
                    <h3>18ºC</h3>
                    <h6>26%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Thursday') }}</h4>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherWind.png') }}" alt="Wind">
                    <h3>17ºC</h3>
                    <h6>10%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Friday') }}</h4>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherPartlyCloudy.png') }}" alt="Partly Cloudy">
                    <h3>23ºC</h3>
                    <h6>17%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Saturday') }}</h4>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherLightning.png') }}" alt="Lightning">
                    <h3>20ºC</h3>
                    <h6>45%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Sunday') }}</h4>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherRaining.png') }}" alt="Raining">
                    <h3>12ºC</h3>
                    <h6>89%</h6>
                </div>
            </div>
        </div>


        <!-- Train/Bus Tickets Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Train/Bus Tickets') }}</h3>
            <hr class="section-divider" style="background-color: #2081A5;">
        </div>
        <p style="text-align: center; font-size: 1.7rem; margin-bottom: 20px;">{{ __('messages.Seems like you didn\'t buy train/bus tickets!') }}</p>
        <div class="button-group">
            <button class="btn btn-primary" style="background-color: #2081A5;">{{ __('messages.Buy Train Tickets') }}</button>
            <button class="btn btn-primary" style="background-color: #2081A5;">{{ __('messages.Buy Bus Tickets') }}</button>
        </div>
    </div>

    <x-footer />
</body>

</html>
