<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/tours.css', 'resources/css/pagination.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/tours.js'])
</head>

<body>
    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Tours') }}</h1>
        <p>{{ __('messages.Explore Our Tours & Activities') }}</p>
    </section>

    <div class="tour">
        <!-- Tours -->

        <div class="title-line-container tour-section">
            <h2>{{ __('messages.Tours') }}</h2>
            <hr class="title-line-blue">
            <div class="sortby-container">
                <span>{{ __('messages.Sort By') }}</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="{{ __('messages.Sort Icon') }}">
                <div id="sortDropdown" class="sortDropdown dropdown-content">
                    <a href="#" onclick="sortByPriceAsc()">{{ __('messages.Price: Low to High') }}</a>
                    <a href="#" onclick="sortByPriceDesc()">{{ __('messages.Price: High to Low') }}</a>
                    <a href="#" onclick="sortAlphabetically()">{{ __('messages.Alphabetically') }}</a>
                    <a href="#" onclick="sortByMostBooked()">{{ __('messages.Most Booked') }}</a>
                </div>
            </div>
        </div>

        <div class="single-column-container">
            @foreach ($tours as $tour)
            <a href="{{ route('tour.tour', ['locale' => app()->getLocale(), 'id' => $tour->id_item]) }}" class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="{{ $tour->item->images[0]->url ?? asset('images/default-hotel.jpg') }}" alt="{{ $tour->name }}">
                    <div class="price-tag">{{ $tour->price_hour}}€<span> /{{ __('messages.per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ $tour->name}}</h2>
                    <p>{{ $tour->description}}</p>
                    <div class="location-info">
                        <span><i class="fas fa-globe"></i> {{ $tour->country }}</span>
                        <span><i class="fas fa-city"></i> {{ $tour->city }}</span>
                        <span><i class="fas fa-road"></i> {{ $tour->street }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Adicionando os links de paginação -->
    <div class="pagination">
        {{ $tours->links('vendor.pagination.custom') }}
    </div>
    <x-footer />
</body>

</html>