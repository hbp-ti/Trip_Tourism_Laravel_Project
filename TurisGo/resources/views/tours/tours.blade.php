<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tour</title>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
        @vite(['resources/css/tours.css'])
    </head>
    <body>
        <x-header />

        <!-- Hero Section -->
        <div class="header">
            <h1>Tours</h1>
            <p>Explore Our Tours & Activities</p>
        </div>

        <div class="tour">

            <!-- Exclusive Tour Packages -->

            <div class="title-line-container tour-section">
                <h2>Exclusive Tour Packages</h2>
                <hr class="title-line-orange">
            </div>

            <div class="single-column-container">
                <div class="exclusive-card">
                    <div class="image-container">
                        <img src="" alt="Exclusive Image 1">
                    </div>
                    <div class="text-container">
                        <h2>Fátima and Coimbra Day Trip</h2>
                    </div>
                </div>
                <div class="exclusive-card">
                    <div class="image-container">
                        <img src="" alt="Exclusive Image 2">
                    </div>
                    <div class="text-container">
                        <h2>Sintra Full-Day Private Tour</h2>
                    </div>
                </div>
                <div class="exclusive-card">
                    <div class="image-container">
                        <img src="" alt="Exclusive Image 3">
                    </div>
                    <div class="text-container">
                        <h2>Authentic Douro Wine Tour</h2>
                    </div>
                </div>
            </div>

            <!-- Tours -->

            <div class="title-line-container tour-section">
                <h2>Tours</h2>
                <hr class="title-line-blue">
                <div class="sortby-container">
                    <span>Sort By</span>
                    <img src="{{ asset('images/sortbyIcon.png') }}" alt="">
                </div>
            </div>

            <div class="single-column-container">
                <div class="tourActivity-card">
                    <div class="image-container-tourActivity">
                        <img src="" alt="Tour Image 1">
                    </div>
                    <div class="text-container">
                        <h2>Douro Valley: Historical Sites, Wine Experience, Lunch & Cruise</h2>
                        <p>Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup</p>
                    </div>
                </div>
                <div class="tourActivity-card">
                    <div class="image-container-tourActivity">
                        <img src="" alt="Tour Image 2">
                    </div>
                    <div class="text-container">
                        <h2>Porto 3-Hour Food and Wine Tasting Tour</h2>
                        <p>Explore Porto’s vibrant cafés and markets on a guided culinary tour. Taste local specialties like tapas, pastries, coffee, beer, and port wine while learning about the city’s rich culture</p>
                    </div>
                </div>
                <div class="tourActivity-card">
                    <div class="image-container-tourActivity">
                        <img src="" alt="Tour Image 3">
                    </div>
                    <div class="text-container">
                        <h2>Porto 3-Hour Food and Wine Tasting Tour</h2>
                        <p>Explore Porto’s vibrant cafés and markets on a guided culinary tour. Taste local specialties like tapas, pastries, coffee, beer, and port wine while learning about the city’s rich culture</p>
                    </div>
                </div>
            </div>

            <!-- Activities -->

            <div class="title-line-container tour-section">
                <h2>Activities</h2>
                <hr class="title-line-orange">
                <div class="sortby-container">
                    <span>Sort By</span>
                    <img src="{{ asset('images/sortbyIcon.png') }}" alt="">
                </div>
            </div>

            <div class="single-column-container">
                <div class="tourActivity-card">
                    <div class="image-container-tourActivity">
                        <img src="" alt="Activity Image 1">
                    </div>
                    <div class="text-container">
                        <h2>Porto 3-Hour Food and Wine Tasting Tour</h2>
                        <p>Explore the coast of Albufeira aboard a semi-rigid boat, visiting hidden spots and the famous Benagil Cave. Swim and spot dolphins along the way (weather permitting)</p>
                    </div>
                </div>
                <div class="tourActivity-card">
                    <div class="image-container-tourActivity">
                        <img src="" alt="Activity Image 2">
                    </div>
                    <div class="text-container">
                        <h2>Porto 3-Hour Food and Wine Tasting Tour</h2>
                        <p>Explore Albufeira's mountains on a thrilling Jeep safari. Enjoy off-road fun, visit a medieval castle, fruit plantations, traditional villages, and stop for a swim and food tasting</p>
                    </div>
                </div>
                <div class="tourActivity-card">
                    <div class="image-container-tourActivity">
                        <img src="" alt="Activity Image 3">
                    </div>
                    <div class="text-container">
                        <h2>Half Day Tour with Jeep Safari in the Algarve Mountains</h2>
                        <p>Explore Albufeira's mountains on a thrilling Jeep safari. Enjoy off-road fun, visit a medieval castle, fruit plantations, traditional villages, and stop for a swim and food tasting</p>
                    </div>
                </div>
            </div>

        </div>


        <x-footer />
    </body>
    </html>
