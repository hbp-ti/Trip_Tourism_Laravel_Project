<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/tours.css'])
</head>

<body>
    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('Tours') }}</h1>
        <p>{{ __('Explore Our Tours & Activities') }}</p>
    </section>

    <div class="tour">

        <!-- Exclusive Tour Packages -->

        <div class="title-line-container tour-section">
            <h2>{{ __('Exclusive Tour Packages') }}</h2>
            <hr class="title-line-orange">
        </div>

        <div class="single-column-container">
            <div class="exclusive-card">
                <div class="image-container">
                    <img src="" alt="{{ __('Exclusive Image 1') }}">
                </div>
                <div class="text-container">
                    <h2>{{ __('Fátima and Coimbra Day Trip') }}</h2>
                </div>
            </div>
            <div class="exclusive-card">
                <div class="image-container">
                    <img src="" alt="{{ __('Exclusive Image 2') }}">
                </div>
                <div class="text-container">
                    <h2>{{ __('Sintra Full-Day Private Tour') }}</h2>
                </div>
            </div>
            <div class="exclusive-card">
                <div class="image-container">
                    <img src="" alt="{{ __('Exclusive Image 3') }}">
                </div>
                <div class="text-container">
                    <h2>{{ __('Authentic Douro Wine Tour') }}</h2>
                </div>
            </div>
        </div>

        <!-- Tours -->

        <div class="title-line-container tour-section">
            <h2>{{ __('Tours') }}</h2>
            <hr class="title-line-blue">
            <div class="sortby-container">
                <span>{{ __('Sort By') }}</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="{{ __('Sort Icon') }}">
            </div>
        </div>

        <div class="single-column-container">
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('Tour Image 1') }}">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Douro Valley: Historical Sites, Wine Experience, Lunch & Cruise') }}</h2>
                    <p>{{ __('Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup') }}</p>
                </div>
            </div>
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('Tour Image 2') }}">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Porto 3-Hour Food and Wine Tasting Tour') }}</h2>
                    <p>{{ __('Explore Porto’s vibrant cafés and markets on a guided culinary tour. Taste local specialties like tapas, pastries, coffee, beer, and port wine while learning about the city’s rich culture') }}</p>
                </div>
            </div>
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('Tour Image 3') }}">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Porto 3-Hour Food and Wine Tasting Tour') }}</h2>
                    <p>{{ __('Explore Porto’s vibrant cafés and markets on a guided culinary tour. Taste local specialties like tapas, pastries, coffee, beer, and port wine while learning about the city’s rich culture') }}</p>
                </div>
            </div>
        </div>

        <!-- Activities -->

        <div class="title-line-container tour-section">
            <h2>{{ __('Activities') }}</h2>
            <hr class="title-line-orange">
            <div class="sortby-container">
                <span>{{ __('Sort By') }}</span>
                <img src="{{ asset('images/sortbyIcon.png') }}" alt="{{ __('Sort Icon') }}">
            </div>
        </div>

        <div class="single-column-container">
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('Activity Image 1') }}">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Porto 3-Hour Food and Wine Tasting Tour') }}</h2>
                    <p>{{ __('Explore the coast of Albufeira aboard a semi-rigid boat, visiting hidden spots and the famous Benagil Cave. Swim and spot dolphins along the way (weather permitting)') }}</p>
                </div>
            </div>
            <div class="tourActivity-card">
                <div class="image-container-tourActivity">
                    <img src="" alt="{{ __('Activity Image 2') }}">
                    <div class="price-tag">$75<span> /{{ __('per person') }}</span></div>
                </div>
                <div class="text-container">
                    <h2>{{ __('Half Day Tour with Jeep Safari in the Algarve Mountains') }}</h2>
                    <p>{{ __('Explore Albufeira\'s mountains on a thrilling Jeep safari. Enjoy off-road fun, visit a medieval castle, fruit plantations, traditional villages, and stop for a swim and food tasting') }}</p>
                </div>
            </div>
        </div>

    </div>

    <x-footer />
</body>

</html>
