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

    @vite(['resources/css/hotels.css', 'resources/css/pagination.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/hotels.js', 'resources/js/mapa.js', 'resources/js/searchBar.js'])
</head>

<body>

    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Hotel') }}</h1>
        <p>{{ __('messages.Discover the Best Hotels for Your Stay') }}</p>
    </section>

    <div class="box">
        <form>
            @csrf
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


    <div class="hotel">
        <!-- Mapa Interativo com Hoteis -->
        <div id="map"></div>

        <!-- Lista de Hoteis -->
        <div class="title-line-container hotel-section">
            <h2>{{ __('messages.Hotel') }}</h2>
            <hr class="title-line-blue">
            <div id="sortBy" class="sortby-container">
                <span>{{ __('messages.Sort By') }}</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="{{ __('messages.Sort By') }}">
                <div id="sortDropdown" class="sortDropdown dropdown-content">
                    <a href="{{ route('hotels', ['locale' => app()->getLocale(), 'sort' => 'price_asc']) }}">{{ __('messages.Price: Low to High') }}</a>
                    <a href="{{ route('hotels', ['locale' => app()->getLocale(), 'sort' => 'price_desc']) }}">{{ __('messages.Price: High to Low') }}</a>
                    <a href="{{ route('hotels', ['locale' => app()->getLocale(), 'sort' => 'alphabetical']) }}">{{ __('messages.Alphabetically') }}</a>
                    
                    <a href="{{ route('hotels', ['locale' => app()->getLocale(), 'sort' => 'most_booked']) }}">{{ __('messages.Most Booked') }}</a>
                </div>
            </div>


            <div class="filter toggle-sidebar" id="toggle-sidebar">
                <span>{{ __('messages.Filter') }}</span>
                <img src="{{ asset('images/filterControl.png') }}" alt="{{ __('messages.Filter') }}">
            </div>
        </div>


        <div class="single-column-container">
            @foreach ($hotels as $hotel)
                <a href="{{ route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item]) }}"
                    class="hotel-card" data-bookings="{{ $hotel->rooms->count() }}">
                    <div class="image-container-hotel">
                        <img src="{{ $hotel->item->images[0]->url ?? asset('images/default-hotel.jpg') }}" alt="{{ $hotel->name }}">
                        
                        @if ($hotel->rooms->isNotEmpty()) <!-- Verifica se o hotel tem quartos -->
                            <div class="price-tag">
                                {{ $hotel->rooms->first()->price_night }}€<span> /{{ __('messages.per night') }}</span>
                            </div>
                        @else
                            <div class="price-tag">
                                {{ __('messages.No rooms available') }}
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


        <div id="blur-overlay" class="blur-overlay"></div>
        <!-- Barra lateral -->
        <div id="sidebar" class="sidebar">
            <h2>{{ __('messages.Hotel Filters') }}</h2>
            <form method="GET" action="{{ route('hotels', ['locale' => app()->getLocale()]) }}">
            <button type="submit" id="apply-filters-btn" class="button-apply-filters">{{ __('Apply Filters') }}</button>
                <div class="filter-group">
                    <h3><img src="{{ asset('images/sidebarPrice.png') }}" alt="Price Range Icon">
                        {{ __('messages.Price Range') }}</h3>
                    <select name="price_range">
                        <option value="">{{ __('Select Price') }}</option>
                        <option value="50-100" {{ request('price_range') == '50-100' ? 'selected' : '' }}>50 - 100€</option>
                        <option value="100-200" {{ request('price_range') == '100-200' ? 'selected' : '' }}>100 - 200€</option>
                        <option value="200-300" {{ request('price_range') == '200-300' ? 'selected' : '' }}>200 - 300€</option>
                        <option value="300-400" {{ request('price_range') == '300-400' ? 'selected' : '' }}>300 - 400€</option>
                    </select>
                </div>
                <div class="filter-group">
                    <h3><img src="{{ asset('images/sidebarHotelStars.png') }}" alt="Hotel Stars">
                        {{ __('messages.Hotel Stars') }}</h3>
                    <select name="hotel_stars">
                        <option value="">{{ __('Select Stars') }}</option> <!-- Opção para não selecionar nenhum filtro por padrão -->
                        <option value="1 star" {{ request('hotel_stars') == '1 star' ? 'selected' : '' }}>{{ __('messages.1 star') }}</option>
                        <option value="2 stars" {{ request('hotel_stars') == '2 stars' ? 'selected' : '' }}>{{ __('messages.2 stars') }}</option>
                        <option value="3 stars" {{ request('hotel_stars') == '3 stars' ? 'selected' : '' }}>{{ __('messages.3 stars') }}</option>
                        <option value="4 stars" {{ request('hotel_stars') == '4 stars' ? 'selected' : '' }}>{{ __('messages.4 stars') }}</option>
                        <option value="5 stars" {{ request('hotel_stars') == '5 stars' ? 'selected' : '' }}>{{ __('messages.5 stars') }}</option>
                    </select>
                </div>
                <div class="filter-group">
                    <h3><img src="{{ asset('images/sidebarStar.png') }}" alt="Price Range Icon">
                        {{ __('messages.Guest Ratings') }}</h3>
                    <select name="guest_ratings">
                        <option value="">{{ __('Select Guest Ratings') }}</option> <!-- Opção para não selecionar nenhum filtro por padrão -->
                            <option value="0-1" {{ request('guest_ratings') == '0-1' ? 'selected' : '' }}>{{ __('0-1') }}</option>
                            <option value="1-2" {{ request('guest_ratings') == '1-2' ? 'selected' : '' }}>{{ __('1-2') }}</option>
                            <option value="2-3" {{ request('guest_ratings') == '2-3' ? 'selected' : '' }}>{{ __('2-3') }}</option>
                            <option value="3-4" {{ request('guest_ratings') == '3-4' ? 'selected' : '' }}>{{ __('3-4') }}</option>
                            <option value="4-5" {{ request('guest_ratings') == '4-5' ? 'selected' : '' }}>{{ __('4-5') }}</option>
                    </select>
                </div>
                <div class="filter-group">
                    <h3><img src="{{ asset('images/sidebarSettings.png') }}" alt="Price Range Icon">
                        {{ __('messages.Facilities and Services') }}</h3>
                    <div>
                        <label>
                            {{ __('messages.Breakfast included') }}
                            <label class="switch">
                                <input type="checkbox" name="breakfast_included">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Free Wi-Fi') }}
                            <label class="switch">
                                <input type="checkbox" name="free_wifi">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Parking') }}
                            <label class="switch">
                                <input type="checkbox" name="parking">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Gym') }}
                            <label class="switch">
                                <input type="checkbox" name="gym">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Pool') }}
                            <label class="switch">
                                <input type="checkbox" name="pool">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Spa and wellness') }}
                            <label class="switch">
                                <input type="checkbox" name="spa_wellness">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Hotel restaurant') }}
                            <label class="switch">
                                <input type="checkbox" name="hotel_restaurant">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Bar') }}
                            <label class="switch">
                                <input type="checkbox" name="bar">
                                <span class="slider"></span>
                            </label>
                        </label>
                        <label>
                            {{ __('messages.Refundable reservations') }}
                            <label class="switch">
                                <input type="checkbox" name="refundable_reservations">
                                <span class="slider"></span>
                            </label>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="pagination">
        {{ $hotels->links('vendor.pagination.custom') }}
    </div>


    <x-footer />

    <script>
        const appUrl = "{{ config('app.url') }}";

        const hotels = @json($hotelCoordinates);
    </script>
</body>

</html>