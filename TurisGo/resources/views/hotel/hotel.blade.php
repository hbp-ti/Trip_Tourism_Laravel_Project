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

    <!-- SweetAlert para popups -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @vite(['resources/css/hotel.css', 'resources/js/mapa.js', 'resources/js/hotel.js', 'resources/js/jquery-3.7.1.min.js', 'resources/js/searchBar.js'])
</head>
<body>

    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>{{ __('Hotel') }}</h1>
        <p>{{ __('Discover the Best Hotels for Your Stay') }}</p>
    </section>

    <div class="box">
        <div class="search-home-page">
            <div class="overlap-group">
                <div class="search-field">
                    <label for="location">{{ __('Destination') }}</label>
                    <input type="text" id="location" placeholder="{{ __('Enter location') }}" />
                </div>
                <div class="search-field">
                    <label for="checkin">{{ __('Check-in Date') }}</label>
                    <input type="text" id="checkin" placeholder="{{ __('Check-in Date') }}" />
                </div>
                <div class="search-field">
                    <label for="checkout">{{ __('Checkout Date') }}</label>
                    <input type="text" id="checkout" placeholder="{{ __('Checkout Date') }}" />
                </div>
                <div class="search-field">
                    <label for="people">{{ __('People') }}</label>
                    <select id="people">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="search-button">
                    <button type="button">{{ __('Search') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="hotel">
        <!-- Mapa Interativo com Hoteis -->
        <div id="map"></div>

        <!-- Lista de Hoteis -->
        <div class="title-line-container hotel-section">
            <h2>{{ __('Hotel') }}</h2>
            <hr class="title-line-blue">
            <div class="sortby-container">
                <span>{{ __('Sort By') }}</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="{{ __('Sort By') }}">
                <div id="sortDropdown" class="dropdown-content">
                    <a href="#" onclick="sortByPriceAsc()">{{ __('Price: Low to High') }}</a>
                    <a href="#" onclick="sortByPriceDesc()">{{ __('Price: High to Low') }}</a>
                    <a href="#" onclick="sortAlphabetically()">{{ __('Alphabetically') }}</a>
                    <a href="#" onclick="sortByMostBooked()">{{ __('Most Booked') }}</a>
                </div>
            </div>
            <div class="filter">
                <span>{{ __('Filter') }}</span>
                <img src="{{ asset('images/filterControl.png') }}" alt="{{ __('Filter') }}">
            </div>
        </div>

        <div class="single-column-container">
            <div class="hotel-card">
                <div class="image-container-hotel">
                    <img src="" alt="{{ __('Hotel Image') }} 1">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Hotel Condade Castro') }}</h2>
                    <p>{{ __('Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup') }}</p>
                </div>
            </div>
            <div class="hotel-card">
                <div class="image-container-hotel">
                    <img src="" alt="{{ __('Hotel Image') }} 1">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Hotel Condade Castro') }}</h2>
                    <p>{{ __('Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup') }}</p>
                </div>
            </div>
            <div class="hotel-card">
                <div class="image-container-hotel">
                    <img src="" alt="{{ __('Hotel Image') }} 1">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Hotel Condade Castro') }}</h2>
                    <p>{{ __('Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup') }}</p>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</body>
</html>
