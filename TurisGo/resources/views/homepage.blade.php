<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

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

    <!-- SweetAlert para popups -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    <!-- Linha modificada com o caminho atualizado do footer.css -->
    @vite(['resources/css/homepage.css', 'resources/js/app.js', 'resources/js/mapa.js', 'resources/js/jquery-3.7.1.min.js', 'resources/js/searchBar.js'])
    @endif

</head>

<body>
    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>{{ __('TurisGo') }}</h1>
        <p>{{ __('Discover your destination') }}</p>
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

    <div class="home">
        <div class="title-line-container home-section">
            <h2>{{ __('Most Popular Hotels') }}</h2>
            <hr class="title-line-orange">
        </div>

        <div class="popular-container">
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
        </div>

        <div class="title-line-container home-section">
            <h2>{{ __('Most Popular Tours') }}</h2>
            <hr class="title-line-blue">
        </div>

        <div class="popular-container">
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
            <div class="popular-card"></div>
        </div>

        <div class="title-line-container home-section">
            <h2>{{ __('Interactive Map') }}</h2>
            <hr class="title-line-orange">
        </div>

        <!-- Mapa Interativo -->
        <div id="map"></div>

        <div class="title-line-container home-section">
            <h2>{{ __('Promotional Packages') }}</h2>
        </div>

        <div class="promo-card-wrapper">
            <div class="promo-card-container">
                <div class="promo-card">
                    <img src="" alt="Promo Image 1">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                    <div class="content-tag">
                        <div class="icon-tag"><img src="{{ asset('images/durationTime.png') }}" alt="duration">8H</div>
                        <div class="icon-tag"><img src="{{ asset('images/numberOfPerson.png') }}" alt="people">{{ __('People') }}: <span>8</span></div>
                    </div>
                    <div class="promo-card-content">
                        <p>{{ __('Promotion') }} 1</p>
                    </div>
                    <div class="rating">
                        <img src="{{ asset('images/rating.png') }}" alt="rating">
                    </div>
                </div>
                <div class="promo-card">
                    <img src="" alt="Promo Image 1">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                    <div class="content-tag">
                        <div class="icon-tag"><img src="{{ asset('images/durationTime.png') }}" alt="duration">8H</div>
                        <div class="icon-tag"><img src="{{ asset('images/numberOfPerson.png') }}" alt="people">{{ __('People') }}: <span>8</span></div>
                    </div>
                    <div class="promo-card-content">
                        <p>{{ __('Promotion') }} 1</p>
                    </div>
                    <div class="rating">
                        <img src="{{ asset('images/rating.png') }}" alt="rating">
                    </div>
                </div>
                <div class="promo-card">
                    <img src="" alt="Promo Image 1">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                    <div class="content-tag">
                        <div class="icon-tag"><img src="{{ asset('images/durationTime.png') }}" alt="duration">8H</div>
                        <div class="icon-tag"><img src="{{ asset('images/numberOfPerson.png') }}" alt="people">{{ __('People') }}: <span>8</span></div>
                    </div>
                    <div class="promo-card-content">
                        <p>{{ __('Promotion') }} 1</p>
                    </div>
                    <div class="rating">
                        <img src="{{ asset('images/rating.png') }}" alt="rating">
                    </div>
                </div>  
                <!-- Repeat promo-card as needed -->
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
