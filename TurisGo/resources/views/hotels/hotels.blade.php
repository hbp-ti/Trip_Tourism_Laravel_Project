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
            <div class="search-home-page">
                <!-- Filtro de pesquisa -->
                <div class="overlap-group">
                    <div class="search-field">
                        <label for="location">{{ __('messages.Destination') }}</label>
                        <select name="location" id="location">
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
                <div id="sortDropdown" class="dropdown-content">
                    <a href="#" id="sortByPriceAsc">{{ __('messages.Price: Low to High') }}</a>
                    <a href="#" id="sortByPriceDesc">{{ __('messages.Price: High to Low') }}</a>
                    <a href="#" id="sortAlphabetically">{{ __('messages.Alphabetically') }}</a>
                    <a href="#" id="sortByMostBooked">{{ __('messages.Most Booked') }}</a>
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
                    class="hotel-card">
                    <div class="image-container-hotel">
                        <img src="{{ $hotel->item->images[0]->url ?? asset('images/default-hotel.jpg') }}"
                            alt="{{ $hotel->name }}">

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


        <div id="blur-overlay" class="blur-overlay"></div>
        <!-- Barra lateral -->
        <div id="sidebar" class="sidebar">
            <h2>{{ __('messages.Hotel Filters') }}</h2>
            <div class="filter-group">
                <h3><img src="{{ asset('images/sidebarPrice.png') }}" alt="Price Range Icon">
                    {{ __('messages.Price Range') }}</h3>
                <select>
                    <option value="50-100">50 - 100€</option>
                    <option value="100-200">100 - 200€</option>
                    <option value="200-300">200 - 300€</option>
                    <option value="200-300">300 - 400€</option>
                </select>
            </div>
            <div class="filter-group">
                <h3><img src="{{ asset('images/sidebarCategory.png') }}" alt="Price Range Icon">
                    {{ __('messages.Hotel Category') }}</h3>
                <select>
                    <option value="typeOf">{{ __('messages.Type of hotel') }}</option>
                </select>
            </div>
            <div class="filter-group">
                <h3><img src="{{ asset('images/sidebarHotelStars.png') }}" alt="Hotel Stars">
                    {{ __('messages.Hotel Stars') }}</h3>
                <select>
                    <option value="1 star">{{ __('messages.1 star') }}</option>
                    <option value="2 stars">{{ __('messages.2 stars') }}</option>
                    <option value="3 stars">{{ __('messages.3 stars') }}</option>
                    <option value="4 stars">{{ __('messages.4 stars') }}</option>
                    <option value="5 stars">{{ __('messages.5 stars') }}</option>
                </select>
            </div>
            <div class="filter-group">
                <h3><img src="{{ asset('images/sidebarStar.png') }}" alt="Price Range Icon">
                    {{ __('messages.Guest Ratings') }}</h3>
                <select>
                    <option value="0-1">{{ __('0-1') }}</option>
                    <option value="1-2">{{ __('1-2') }}</option>
                    <option value="2-3">{{ __('2-3') }}</option>
                    <option value="3-4">{{ __('3-4') }}</option>
                    <option value="4-5">{{ __('4-5') }}</option>
                </select>
            </div>
            <div class="filter-group">
                <h3><img src="{{ asset('images/sidebarSettings.png') }}" alt="Price Range Icon">
                    {{ __('messages.Facilities and Services') }}</h3>
                <div>
                    <label>
                        {{ __('messages.Breakfast included') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Free Wi-Fi') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Parking') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Gym') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Pool') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Spa and wellness') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Hotel restaurant') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                    <label>
                        {{ __('messages.Bar') }}
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </label>
                </div>
            </div>
            <div class="filter-group">
                <h3><img src="{{ asset('images/sidebarCancel.png') }}" alt="Price Range Icon">
                    {{ __('messages.Cancellation Policy') }}</h3>
                <label>
                    {{ __('messages.Free cancellation') }}
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </label>
                <label>
                    {{ __('messages.Refundable reservations') }}
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </label>
            </div>
        </div>
    </div>


    <div class="pagination">
        {{ $hotels->links('vendor.pagination.custom') }}
    </div>


    <x-footer />

    <script>
        const hotels = @json($hotelCoordinates);
    </script>
</body>

</html>