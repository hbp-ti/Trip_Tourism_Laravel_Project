<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TurisGo</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    <!-- Linha modificada com o caminho atualizado do footer.css -->
    @vite(['resources/css/homepage.css', 'resources/js/app.js'])
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
                <div class="overlap">Search</div>
                <div class="place-wrapper">
                    <input type="text" id="location" placeholder="Enter location" />
                </div>
                <div class="calendar-wrapper">
                    <input type="text" id="checkin" placeholder="Check-in Date" />
                </div>
                <div class="icons-calendar-wrapper">
                    <input type="text" id="checkout" placeholder="Checkout Date" />
                </div>
                <div class="div">
                    <select id="people">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="text-wrapper-2">Destination</div>
                <div class="text-wrapper-3">Checkin Date</div>
                <div class="text-wrapper-4">Checkout Date</div>
                <div class="text-wrapper-5">People</div>
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

        <!-- Mapa Interativo da Google -->
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31255.612595920426!2d-8.4463744!3d40.574588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22ebf03068b2b3%3A0x833c2e505b1b476c!2s%C3%81gueda%2C%20Portugal!5e0!3m2!1sen!2spt!4v1696420912345!5m2!1sen!2spt" 
                width="100%" 
                height="100%" 
                style="border:8px;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="title-line-container home-section">
            <h2>Promotional Packages</h2>
        </div>

        <div class="promo-card-wrapper">
            <div class="promo-card-container">
                <div class="promo-card">
                </div>
                <div class="promo-card">
                </div>
                <div class="promo-card">
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