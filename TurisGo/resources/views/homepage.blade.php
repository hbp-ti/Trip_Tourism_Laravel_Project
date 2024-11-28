<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TurisGo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- css e script  de mapa interativo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    <!-- Linha modificada com o caminho atualizado do footer.css -->
    @vite(['resources/css/homepage.css', 'resources/js/app.js', 'resources/js/mapa.js'])
    @endif

</head>

<body>
    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>TurisGo</h1>
        <p>Find your Destination</p>
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


    <div class="home">
        <div class="title-line-container home-section">
            <h2>Most Popular Hotels</h2>
            <hr class="title-line-orange">
        </div>

        <div class="popular-container">
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
        </div>

        <div class="title-line-container home-section">
            <h2>Most Popular Tours</h2>
            <hr class="title-line-blue">
        </div>

        <div class="popular-container">
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
        </div>

        <div class="title-line-container home-section">
            <h2>Interactive Map</h2>
            <hr class="title-line-orange">
        </div>

        <!-- Mapa Interativo -->
        <div id="map"></div>

        <div class="title-line-container home-section">
            <h2>Promotional Packages</h2>
        </div>

        <div class="promo-card-wrapper">
            <div class="promo-card-container">
                <div class="promo-card">
                    <img src="" alt="Promo Image 1">
                    <div class="price-tag">$75<span> /per person</span></div>
                    <div class="content-tag">
                        <div class="icon-tag"><img src="{{ asset('images/durationTime.png') }}" alt="duration">8H</div>
                        <div class="icon-tag"><img src="{{ asset('images/numberOfPerson.png') }}" alt="people">People: <span>8</span></div>
                    </div>
                    <div class="promo-card-content">
                        <p>Promotion 1</p>
                    </div>
                    <div class="rating">
                        <img src="{{ asset('images/rating.png') }}" alt="rating">
                    </div>
                </div>
                <div class="promo-card">
                    <img src="" alt="Promo Image 2">
                    <div class="price-tag">$75<span> /per person</span></div>
                    <div class="content-tag">
                        <div class="icon-tag"><img src="{{ asset('images/durationTime.png') }}" alt="duration">8H</div>
                        <div class="icon-tag"><img src="{{ asset('images/numberOfPerson.png') }}" alt="people">People: <span>8</span></div>
                    </div>
                    <div class="promo-card-content">
                        <p>Promotion 2</p>
                    </div>
                    <div class="rating">
                        <img src="{{ asset('images/rating.png') }}" alt="rating">
                    </div>
                </div>
                <div class="promo-card">
                    <img src="" alt="Promo Image 3">
                    <div class="price-tag">$75<span> /per person</span></div>
                    <div class="content-tag">
                        <div class="icon-tag"><img src="{{ asset('images/durationTime.png') }}" alt="duration">8H</div>
                        <div class="icon-tag"><img src="{{ asset('images/numberOfPerson.png') }}" alt="people">People: <span>8</span></div>
                    </div>
                    <div class="promo-card-content">
                        <p>Promotion 3</p>
                    </div>
                    <div class="rating">
                        <img src="{{ asset('images/rating.png') }}" alt="rating">
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <x-footer />

    <script>
        // Inicializa o flatpickr para os campos de data
        flatpickr("#checkin", {
            dateFormat: "Y-m-d", // formato da data
            minDate: "today",    // data mínima (hoje)
        });

        flatpickr("#checkout", {
            dateFormat: "Y-m-d", // formato da data
            minDate: "today",    // data mínima (hoje)
        });
    </script>
</body>

</html>