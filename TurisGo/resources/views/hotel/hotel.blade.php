<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- css e script  de mapa interativo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/hotel.css', 'resources/js/mapa.js'])
</head>
<body>

    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>Hotel</h1>
        <p>Discover the Best Hotels for Your Stay</p>
    </section>

    <div class="box">
        <div class="search-home-page">
            <div class="overlap-group">
                <div class="search-field">
                    <label for="location">Destination</label>
                    <input type="text" id="location" placeholder="Enter location" />
                </div>
                <div class="search-field">
                    <label for="checkin">Check-in Date</label>
                    <input type="text" id="checkin" placeholder="Check-in Date" />
                </div>
                <div class="search-field">
                    <label for="checkout">Checkout Date</label>
                    <input type="text" id="checkout" placeholder="Checkout Date" />
                </div>
                <div class="search-field">
                    <label for="people">People</label>
                    <select id="people">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="search-button">
                    <button type="button">Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="hotel">
        <!-- Mapa Interativo com Hoteis -->
        <div id="map"></div>

        <!-- Lista de Hoteis -->
        <div class="title-line-container hotel-section">
            <h2>Hotel</h2>
            <hr class="title-line-blue">
            <div class="sortby-container">
                <span>Sort By</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="Sort By">
            </div>
            <div class="filter">
                <span>FIlter</span>
                <img src="{{ asset('images/filterControl.png') }}" alt="Filter">
            </div>
        </div>

        <div class="single-column-container">
            <div class="hotel-card">
                <div class="image-container-hotel">
                    <img src="" alt="Hotel Image 1">
                    <div class="price-tag">$75<span> /per person</span></div>
                </div>
                <div class="text-container">
                    <h2>Hotel Condade Castro</h2>
                    <p>Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup</p>
                </div>
            </div>
            <div class="hotel-card">
                <div class="image-container-hotel">
                    <img src="" alt="Hotel Image 1">
                    <div class="price-tag">$75<span> /per person</span></div>
                </div>
                <div class="text-container">
                    <h2>Hotel Condade Castro</h2>
                    <p>Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup</p>
                </div>
            </div>
            <div class="hotel-card">
                <div class="image-container-hotel">
                    <img src="" alt="Hotel Image 1">
                    <div class="price-tag">$75<span> /per person</span></div>
                </div>
                <div class="text-container">
                    <h2>Hotel Condade Castro</h2>
                    <p>Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup</p>
                </div>
            </div>
        </div>
    </div>


    <x-footer />
</body>
</html>