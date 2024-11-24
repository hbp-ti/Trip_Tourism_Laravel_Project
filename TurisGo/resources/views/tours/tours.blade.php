<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tour</title>
        @vite(['resources/css/tours.css'])
    </head>
    <body>
        <x-header />

        <!-- Hero Section -->
        <div class="header">
            <h1>Tours</h1>
            <p>Explore Our Tours & Activities</p>
        </div>

        <main>
        <div class="backgroundsee">
            <!-- Pacotes Exclusivos -->
            <section class="exclusive-packages">
                <h2>Exclusive Tour Packages</h2>
                <div class="packages">
                    <!-- Card 1 -->
                    <div class="package-card">
                        <img src="{{ asset('images/tourspackage.png') }}" alt="Fátima and Coimbra Day Trip" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$62 / per person</span>
                                <span class="duration">8H</span>
                                <span class="people">People: 10</span>
                            </div>
                            <h3>Fátima and Coimbra Day Trip</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>
        
            

                    <!-- Card 2 -->
                    <div class="package-card">
                        <img src="{{ asset('images/tourspackage.png') }}" alt="Sintra Full-Day Private Tour" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$120 / per person</span>
                                <span class="duration">8H</span>
                                <span class="people">People: 10</span>
                            </div>
                            <h3>Sintra Full-Day Private Tour</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="package-card">
                        <img src="{{ asset('images/tourspackage.png') }}" alt="Authentic Douro Wine Tour" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$125 / per person</span>
                                <span class="duration">9H</span>
                                <span class="people">People: 2</span>
                            </div>
                            <h3>Authentic Douro Wine Tour Including Lunch and River Cruise</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>
                </div>
            </section>
            </div>  
            <!-- Tours -->
            <section class="tours-section">
                <h2>Tours</h2>
                <div class="packages">
                    <!-- Card 1 -->
                    <div class="package-card">
                        <img src="{{ asset('images/tours2.png') }}" alt="Douro Valley Tour" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$94 / per person</span>
                                <span class="duration">6+ hours</span>
                            </div>
                            <h3>Douro Valley: Historical Sites, Wine Experience, Lunch & Cruise</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="package-card">
                        <img src="{{ asset('images/tours2.png') }}" alt="Porto Food Tour" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$82 / per person</span>
                                <span class="duration">3 hours</span>
                            </div>
                            <h3>Porto 3-Hour Food and Wine Tasting Tour</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Activities -->
            <section class="activities-section">
                <h2>Activities</h2>
                <div class="packages">
                    <!-- Card 1 -->
                    <div class="package-card">
                        <img src="{{ asset('images/toursactivity.png') }}" alt="Dolphins and Caves Tour" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$38 / per person</span>
                                <span class="duration">2 - 3 hours</span>
                            </div>
                            <h3>Dolphins and Benagil Caves from Albufeira</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="package-card">
                        <img src="{{ asset('images/toursactivity.png') }}" alt="Jeep Safari" class="package-image">
                        <div class="package-details">
                            <div class="card-header">
                                <span class="price">$39 / per person</span>
                                <span class="duration">4 hours</span>
                            </div>
                            <h3>Half Day Tour with Jeep Safari in the Algarve Mountains</h3>
                            <p class="rating">★★★★★</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </body>
    </html>
