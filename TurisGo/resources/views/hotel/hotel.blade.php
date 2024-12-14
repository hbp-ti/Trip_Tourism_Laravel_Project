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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @vite(['resources/css/hotel.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/mapa.js', 'resources/js/hotel.js', 'resources/js/searchBar.js'])
</head>

<body>

    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Hotel') }}</h1>
        <p>{{ __('messages.Discover the Best Hotels for Your Stay') }}</p>
    </section>

    <div class="box">
        <div class="search-home-page">
            <div class="overlap-group">
                <div class="search-field">
                    <label for="location">{{ __('messages.Destination') }}</label>
                    <input type="text" id="location" placeholder="{{ __('messages.Enter location') }}" />
                </div>
                <div class="search-field">
                    <label for="checkin">{{ __('messages.Check-in Date') }}</label>
                    <input type="text" id="checkin" placeholder="{{ __('messages.Check-in Date') }}" />
                </div>
                <div class="search-field">
                    <label for="checkout">{{ __('messages.Checkout Date') }}</label>
                    <input type="text" id="checkout" placeholder="{{ __('messages.Checkout Date') }}" />
                </div>
                <div class="search-field">
                    <label for="people">{{ __('messages.People') }}</label>
                    <select id="people">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="search-button">
                    <button type="button">{{ __('messages.Search') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="hotel">
        <!-- Mapa Interativo com Hoteis -->
        <div id="map"></div>

        <!-- Lista de Hoteis -->
        <div class="title-line-container hotel-section">
            <h2>{{ __('messages.Hotel') }}</h2>
            <hr class="title-line-blue">
            <div class="sortby-container">
                <span>{{ __('messages.Sort By') }}</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="{{ __('messages.Sort By') }}">
                <div id="sortDropdown" class="dropdown-content">
                    <a href="#" onclick="sortByPriceAsc()">{{ __('messages.Price: Low to High') }}</a>
                    <a href="#" onclick="sortByPriceDesc()">{{ __('messages.Price: High to Low') }}</a>
                    <a href="#" onclick="sortAlphabetically()">{{ __('messages.Alphabetically') }}</a>
                    <a href="#" onclick="sortByMostBooked()">{{ __('messages.Most Booked') }}</a>
                </div>
            </div>
            <div class="filter toggle-sidebar" id="toggle-sidebar">
                <span>{{ __('messages.Filter') }}</span>
                <img src="{{ asset('images/filterControl.png') }}" alt="{{ __('messages.Filter') }}">
            </div>
        </div>


        <div class="single-column-container">
            @foreach ($hotels as $hotel)
            <a href="{{ route('hotel.details', ['locale' => app()->getLocale(), 'id' => $hotel->id_item]) }}" class="hotel-card">
                <div class="image-container-hotel">
                    <img src="{{ $hotel->image_url ?? asset('images/default-hotel.jpg') }}" alt="{{ $hotel->name }}">

                    @if ($hotel->rooms->isNotEmpty()) <!-- Verifica se o hotel tem quartos -->
                    <div class="price-tag">
                        {{ $hotel->rooms->first()->price_night }}€ <!-- Exibe o preço do quarto mais barato -->
                        <span> /{{ __('messages.per night') }}</span>
                    </div>
                    @else
                    <div class="price-tag">
                        {{ __('messages.No rooms available') }} <!-- Exibe mensagem se não houver quartos -->
                    </div>
                    @endif
                </div>
                <div class="text-container">
                    <h2>{{ $hotel->name }}</h2>
                    <p>{{ $hotel->description }}</p>
                    <div class="location-info">
                        <span><i class="fas fa-globe"></i> {{ $hotel->country }}</span>
                        <span><i class="fas fa-city"></i> {{ $hotel->city }}</span>
                        <span><i class="fas fa-road"></i> {{ $hotel->street }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>



        <!-- Adicionando os links de paginação -->
        <div class="pagination">
            {{ $hotels->links() }}
        </div>


        <x-footer />
</body>

</html>