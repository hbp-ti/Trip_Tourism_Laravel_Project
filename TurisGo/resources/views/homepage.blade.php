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
    @vite(['resources/css/homepage.css'])
    @vite(['resources/js/app.js'])
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