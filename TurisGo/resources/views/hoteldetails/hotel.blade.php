<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/hotel_details.css'], ['resources/js/jquery-3.7.1.min.js'], ['resources/js/hotel_details.js'])
</head>

<body>
    <x-header />

    <!-- Header Section -->
    <section class="header">
        <h1>Hotel Condade<br>Castro</h1>
    </section>

    <section class="image-slider">
        <div class="slider-images">
            <img src="/images/darkhotel_image.png" alt="Hotel Image 1" class="slider-image">
            <img src="/images/darkhotel_image.png" alt="Hotel Image 2" class="slider-image hidden">
            <img src="/images/darkhotel_image.png" alt="Hotel Image 3" class="slider-image hidden">
        </div>
        <div class="slider-controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>
        <div class="dots-container">
            <span class="dot active-dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>


    <!-- Description Section -->
    <section class="hotel-description">
        <p>
            Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup. Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup. Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup. Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup. Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup
        </p>
    </section>

    <!-- Facilities Section -->
    <section class="facilities">
        <div class="title-line-container">
            <h2>Most popular facilities</h2>
            <hr class="title-line">
        </div>
        <div class="facility-icons">
            <div class="icon">
                <img src="/images/wifi_free_icon.png" alt="WiFi">
                <span>Free WiFi</span>
            </div>
            <div class="icon">
                <img src="/images/pool_icon.png" alt="Pool">
                <span>Pool</span>
            </div>
            <div class="icon">
                <img src="/images/bar_icon.png" alt="Bar">
                <span>Bar</span>
            </div>
            <div class="icon">
                <img src="/images/parking_icon.png" alt="Parking">
                <span>Free Parking</span>
            </div>
            <div class="icon">
                <img src="/images/no_smoking_icon.png" alt="Parking">
                <span>No smoking</span>
            </div>
        </div>
    </section>

    <section class="availability">
        <div class="title-line-container">
            <h2>Availability</h2>
            <hr class="title-line-orange">
        </div>

        <!-- Search Form Section -->
        <div class="availability-form">
            <div>
                <label for="checkin">Check-in date</label>
                <input type="date" id="checkin">
            </div>

            <div>
                <label for="checkout">Check-out date</label>
                <input type="date" id="checkout">
            </div>

            <div>
                <label for="guests">People</label>
                <select id="guests">
                    <option>1 Adult</option>
                    <option>2 Adults</option>
                    <option>3 Adults</option>
                </select>
            </div>

            <button>Search</button>
        </div>


        <!-- Availability Table -->
        <div class="availability-table-container">
            <table class="availability-table">
                <thead>
                    <tr>
                        <th>Accommodation Type</th>
                        <th>People</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Executive Double Room</td>
                        <td>2</td>
                        <td>€270</td>
                        <td><button class="book-btn">Reserve</button></td>
                    </tr>
                    <tr>
                        <td>Deluxe Double Room</td>
                        <td>2</td>
                        <td>€320</td>
                        <td><button class="booked-btn" disabled>Reserve</button></td>
                    </tr>
                    <tr>
                        <td>Suite</td>
                        <td>4</td>
                        <td>€600</td>
                        <td><button class="book-btn">Reserve</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>



    <!-- Guest Reviews -->
    <section class="reviews">
        <div class="title-line-container">
            <h2>Guest Reviews</h2>
            <hr class="title-line">
        </div>
        <div class="reviews-container">
            <div class="review-box">
                <div class="review-header">
                    <img src="/images/default_user_image.png" alt="User 1" class="review-img">
                    <span class="user-name">John</span>
                </div>
                <p class="review-text">"Fantastic hotel with great staff!"</p>
                <p class="review-excerpt">This hotel is amazing, the staff is very friendly and helpful. The amenities were top-notch and...</p>
                <span class="read-more">Read More</span>
            </div>
            <div class="review-box">
                <div class="review-header">
                    <img src="/images/default_user_image.png" alt="User 2" class="review-img">
                    <span class="user-name">Mary</span>
                </div>
                <p class="review-text">"Beautiful location, will come again."</p>
                <p class="review-excerpt">The location of the hotel is perfect for sightseeing, and the rooms were very comfortable...</p>
                <span class="read-more">Read More</span>
            </div>
            <div class="review-box">
                <div class="review-header">
                    <img src="/images/default_user_image.png" alt="User 3" class="review-img">
                    <span class="user-name">Alice</span>
                </div>
                <p class="review-text">"Great experience, highly recommended!"</p>
                <p class="review-excerpt">I had a wonderful stay at the hotel, and everything exceeded my expectations...</p>
                <span class="read-more">Read More</span>
            </div>
        </div>
        <div class="reviews-buttons">
            <button class="read-all-reviews">Read All Reviews</button>
            <button class="add-review"><span class="plus-icon">+</span> Add a Review</button>
        </div>
    </section>


    <!-- Similar Hotels Section -->
    <section class="similar-hotels">
        <div class="title-line-container">
            <h2>Similar Hotels</h2>
            <hr class="title-line-orange">
        </div>
        <div class="hotels">
            <img src="/images/condade.png" alt="Hotel 1">
            <img src="/images/condade.png" alt="Hotel 2">
            <img src="/images/condade.png" alt="Hotel 3">
            <img src="/images/condade.png" alt="Hotel 4">
        </div>
    </section>


    <x-footer />
</body>

</html>