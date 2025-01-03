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
    @vite(['resources/css/homepage.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/app.js', 'resources/js/mapa.js', 'resources/js/searchBar.js', 'resources/js/homepage.js'])
    @endif

</head>

<body>
    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>{{ __('messages.TurisGo') }}</h1>
        <p>{{ __('messages.Discover your destination') }}</p>
    </section>

    <div class="box">
    <form>
            <div class="search-home-page">
                <!-- Filtro de pesquisa -->
                <div class="overlap-group">
                    <div class="search-field">
                        <label for="location">{{ __('messages.Destination') }}</label>
                        <select name="location" id="location">
                        <option value="All">{{ __('messages.All') }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="checkin">{{ __('messages.Check-in Date') }}</label>
                        <input type="text" name="checkin" id="checkin" placeholder="{{ __('messages.Check-in Date') }}" />
                    </div>
                    <div class="search-field">
                        <label for="checkout">{{ __('messages.Checkout Date') }}</label>
                        <input type="text" name="checkout" id="checkout" placeholder="{{ __('messages.Checkout Date') }}" />
                    </div>
                    <div class="search-field">
                        <label for="people">{{ __('messages.People') }}</label>
                        <select name="people" id="people">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="search-button">
                        <button type="submit" id="searchButton">{{ __('messages.Search') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="home">
        <div class="title-line-container home-section">
            <h2>{{ __('messages.Most Popular Hotels') }}</h2>
            <hr class="title-line-orange">
        </div>

        <div class="popular-container">
            @foreach($popularHotels as $hotel)
            <a href="{{ route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item]) }}">
                <div class="popular-card">
                    <img src="{{ $hotel->item->images[0]->url }}" alt="Imagem do Hotel">
                </div>
            </a>
            @endforeach
        </div>


        <div class="title-line-container home-section">
            <h2>{{ __('messages.Most Popular Tours') }}</h2>
            <hr class="title-line-blue">
        </div>

        <div class="popular-container">
            @foreach($popularTours as $tour)
            <a href="{{ route('tour.tour', ['locale' => app()->getLocale(), 'id' => $tour->id_item]) }}">
                <div class="popular-card">
                    <img src="{{ $tour->item->images[0]->url }}" alt="Imagem da Tour">
                </div>
            </a>
            @endforeach
        </div>

        <div class="title-line-container home-section">
            <h2>{{ __('messages.Interactive Map') }}</h2>
            <hr class="title-line-orange">
        </div>

        <!-- Mapa Interativo -->
        <div id="map"></div>

        <div class="title-line-container home-section">
            <h2>{{ __('User Reviews') }}</h2>
            <hr class="title-line-orange">
        </div>

        <div class="reviews-carousel">
            <h2>What our users say</h2>
            <div class="carousel-slider">
                @foreach ($reviews as $review)
                <div class="review-card">
                    <div class="review-image">
                        <img 
                            src="{{ file_exists(public_path('storage/' . $review->user->image)) ? asset('storage/' . $review->user->image) : asset('images/default_user_image.png') }}" 
                            alt="{{ $review->user->name }}" 
                            class="user-avatar">
                    </div>
                    <div class="review-content">
                        <h3>{{ $review->user->first_name . ' ' . $review->user->last_name }}</h3>
                        <p class="review-description">{{ $review->description }}</p>
                        <span class="rating">Rating: {{ $review->rating }} / 5</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


    </div>

    <x-footer />

    <script>
        const hotels = @json($hotelCoordinates);
        const tours = @json($tourCoordinates);
        

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
