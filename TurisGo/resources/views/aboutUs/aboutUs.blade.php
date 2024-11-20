<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/aboutUs.css'])
</head>
<body>
    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>About</h1>
        <p>Some things about us</p>
    </section>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="title-line-container">
            <h2>About us</h2>
            <hr class="title-line">
        </div>
        <p class="about-text">Welcome to TurisGo! We are a platform dedicated to making travel planning easier by offering an integrated solution that combines hotel searches, cultural activities, routes and transportation options. We believe that the process of planning a trip should be simple and efficient, allowing travelers to focus on what really matters: enjoying their experience.</p>

    </section>
    <h2 class="titleMiddle">Why you should choose our platform</h2>
    
    <!-- ===============  Choose-us start=============== -->

    <div class="choose-us-section">
      <div class="container">
            <div class="single-feature hover-border1 wow fadeInDown h-100" data-wow-duration="1.5s" data-wow-delay=".2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.2s; animation-name: fadeInDown;">
              <span class="sn">01</span>
              <div class="icon">
                <img  width="50" height="50" viewBox="0 0 50 50" src="{{ asset('images/searchIcon.png') }}" alt="Search Icon">
              </div>
              <div class="content">
                <h5>
                  <a>Search and Compare Options</a>
                </h5>
                <p class="para">
                Search and compare hotels and cultural activities in various destinations, helping you make informed choices with detailed information about pricing, location, and reviews.
                </p>
              </div>
            </div>
            <div class="single-feature hover-border1 wow fadeInDown h-100" data-wow-duration="1.5s" data-wow-delay=".4s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.4s; animation-name: fadeInDown;">
              <span class="sn">02</span>
              <div class="icon">
                <img  width="50" height="50" viewBox="0 0 50 50" src="{{ asset('images/weatherIcon.png') }}" alt="Weather Icon">
              </div>
              <div class="content">
                <h5><a>Plan with Weather Insights</a></h5>
                <p class="para">
                Check updated weather forecasts to better plan your trips, ensuring that your activities and travels are perfectly aligned with the expected conditions.
</p>
                </p>
              </div>
            </div>
            <div class="single-feature hover-border1 wow fadeInDown h-100" data-wow-duration="1.5s" data-wow-delay=".6s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.6s; animation-name: fadeInDown;">
              <span class="sn">03</span>
              <div class="icon">
                <img  width="50" height="50" viewBox="0 0 50 50" src="{{ asset('images/promotionsIcon.png') }}" alt="Promotion Icon">
              </div>
              <div class="content">
                <h5><a>Exclusive Promotions</a></h5>
                <p class="para">
                Access exclusive promotional packages with combined hotel and activity offers, tailored to suit your preferences and budget for an enhanced travel experience.
                </p>
              </div>
            </div>
            <div class="single-feature hover-border1 wow fadeInDown h-100" data-wow-duration="1.5s" data-wow-delay=".8s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.8s; animation-name: fadeInDown;">
              <span class="sn">04</span>
              <div class="icon">
                <img  width="50" height="50" viewBox="0 0 50 50" src="{{ asset('images/itineraryIcon.png') }}" alt="Itinerary Icon">
              </div>
              <div class="content">
                <h5><a>Automatic Itineraries</a></h5>
                <p class="para">
                View automatic itineraries with route and transportation suggestions, simplifying your journey by organizing your schedule seamlessly.
                </p>
              </div>
            </div>
            <div class="single-feature hover-border1 wow fadeInDown h-100" data-wow-duration="1.5s" data-wow-delay="1s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 1s; animation-name: fadeInDown;">
              <span class="sn">05</span>
              <div class="icon">
                <img  width="50" height="50" viewBox="0 0 50 50" src="{{ asset('images/bookingIcon.png') }}" alt="Booking Icon">
              </div>
              <div class="content">
                <h5>
                  <a>Book Seamlessly</a>
                </h5>
                <p class="para">
                Book accommodations and activities securely and conveniently, all in one place, saving time and effort while ensuring reliable transactions.
</p>
                </p>
              </div>
            </div>
            <div class="single-feature hover-border1 wow fadeInDown h-100" data-wow-duration="1.5s" data-wow-delay="1.2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 1.2s; animation-name: fadeInDown;">
              <span class="sn">06</span>
              <div class="icon">
                <img  width="50" height="50" viewBox="0 0 50 50" src="{{ asset('images/personalizedSuggestionsIcon.png') }}" alt="Personalized Suggestions Icon">
              </div>
              <div class="content">
                <h5><a>Personalized Suggestions</a></h5>
                <p class="para">
                Get personalized suggestions based on your preferences and bookings, making every trip unique and perfectly tailored to your needs.
                </p>
              </div>
            </div>
        </div>
    </div>
    <!-- ===============  Choose-us end=============== -->

    <!-- Who TurisGo is For Section -->
    <section class="for-section">
        <h2>Who TurisGo is For</h2>
        <p>TurisGo is designed for all travelers who value convenience and simplicity. Whether you’re planning a weekend getaway or a long adventure abroad, TurisGo is here to streamline and enhance your planning experience. Our goal is to streamline the planning process, helping users save time and make the best choices for their trips.</p>
    </section>

    <x-footer/>
</body>
</html>