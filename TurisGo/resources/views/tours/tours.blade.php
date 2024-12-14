<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/tours.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/tour.js'])
</head>

<body>
    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Tours') }}</h1>
        <p>{{ __('messages.Explore Our Tours & Activities') }}</p>
    </section>

    <div class="tour">

        <!-- Exclusive Tour Packages -->

        <div class="title-line-container tour-section">
            <h2>{{ __('messages.Exclusive Tour Packages') }}</h2>
            <hr class="title-line-orange">
        </div>

        <div class="single-column-container">
            <div class="exclusive-card">
                <div class="image-container">
                    <img src="" alt="{{ __('messages.Exclusive Image 1') }}">
                </div>
                <div class="text-container">
                    <h2>{{ __('messages.Fátima and Coimbra Day Trip') }}</h2>
                    <div class="info-banner">
                        <div class="price-info"><span>$75</span> /per person</div>
                        <div class="geral-info">
                            <div><img src="/images/durationTime.png" style="width: 20px;" alt="Duration">8H</div>
                            <div><img src="/images/numberOfPerson.png" style="width: 20px;" alt="People">People: <span>10</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="exclusive-card">
                <div class="image-container">
                    <img src="" alt="{{ __('messages.Exclusive Image 2') }}">
                </div>
                <div class="text-container">
                    <h2>{{ __('messages.Sintra Full-Day Private Tour') }}</h2>
                    <div class="info-banner">
                        <div class="price-info"><span>$75</span> /per person</div>
                        <div class="geral-info">
                            <div><img src="/images/durationTime.png" style="width: 20px;" alt="Duration">8H</div>
                            <div><img src="/images/numberOfPerson.png" style="width: 20px;" alt="People">People: <span>10</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="exclusive-card">
                <div class="image-container">
                    <img src="" alt="{{ __('messages.Exclusive Image 3') }}">
                </div>
                <div class="text-container">
                    <h2>{{ __('messages.Authentic Douro Wine Tour') }}</h2>
                    <div class="info-banner">
                        <div class="price-info"><span>$75</span> /per person</div>
                        <div class="geral-info">
                            <div><img src="/images/durationTime.png" style="width: 20px;" alt="Duration">8H</div>
                            <div><img src="/images/numberOfPerson.png" style="width: 20px;" alt="People">People: <span>10</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('messages.Tour Image 1') }}">
                    <div class="price-tag">$75<span> /{{ __('messages.per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('messages.Douro Valley: Historical Sites, Wine Experience, Lunch & Cruise') }}</h2>
                    <p>{{ __('messages.Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup') }}</p>
                </div>
            </div>
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('messages.Tour Image 2') }}">
                    <div class="price-tag">$75<span> /{{ __('messages.per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('messages.Porto 3-Hour Food and Wine Tasting Tour') }}</h2>
                    <p>{{ __('messages.Explore Porto’s vibrant cafés and markets on a guided culinary tour. Taste local specialties like tapas, pastries, coffee, beer, and port wine while learning about the city’s rich culture') }}</p>
                </div>
            </div>
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('messages.Tour Image 3') }}">
                    <div class="price-tag">$75<span> /{{ __('messages.per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('messages.Porto 3-Hour Food and Wine Tasting Tour') }}</h2>
                    <p>{{ __('messages.Explore Porto’s vibrant cafés and markets on a guided culinary tour. Taste local specialties like tapas, pastries, coffee, beer, and port wine while learning about the city’s rich culture') }}</p>
                </div>
            </div>
        </div>


    </div>

    <x-footer />
</body>

</html>
