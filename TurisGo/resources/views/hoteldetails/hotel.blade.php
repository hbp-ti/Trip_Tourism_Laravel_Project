<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

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
        <h1>{{ __('messages.Hotel Condado') }}<br>{{ __('messages.Castro') }}</h1>
    </section>

    <section class="image-slider">
        <div class="slider-images">
            <img src="/images/darkhotel_image.png" alt="{{ __('messages.Hotel Image 1') }}" class="slider-image">
            <img src="/images/darkhotel_image.png" alt="{{ __('messages.Hotel Image 2') }}" class="slider-image hidden">
            <img src="/images/darkhotel_image.png" alt="{{ __('messages.Hotel Image 3') }}" class="slider-image hidden">
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
            {{ __('messages.Enjoy a full day in the Douro Valley with a cruise, lunch, and wine tasting. Explore the UNESCO-listed landscapes by boat and relax with convenient hotel pickup.') }}
        </p>
    </section>

    <!-- Facilities Section -->
    <section class="facilities">
        <div class="title-line-container">
            <h2>{{ __('messages.Most popular facilities') }}</h2>
            <hr class="title-line">
        </div>
        <div class="facility-icons">
            <div class="icon">
                <img src="/images/wifi_free_icon.png" alt="{{ __('messages.WiFi') }}">
                <span>{{ __('messages.Free WiFi') }}</span>
            </div>
            <div class="icon">
                <img src="/images/pool_icon.png" alt="{{ __('messages.Pool') }}">
                <span>{{ __('messages.Pool') }}</span>
            </div>
            <div class="icon">
                <img src="/images/bar_icon.png" alt="{{ __('messages.Bar') }}">
                <span>{{ __('messages.Bar') }}</span>
            </div>
            <div class="icon">
                <img src="/images/parking_icon.png" alt="{{ __('messages.Parking') }}">
                <span>{{ __('messages.Free Parking') }}</span>
            </div>
            <div class="icon">
                <img src="/images/no_smoking_icon.png" alt="{{ __('messages.No smoking') }}">
                <span>{{ __('messages.No smoking') }}</span>
            </div>
        </div>
    </section>

    <section class="availability">
        <div class="title-line-container">
            <h2>{{ __('messages.Availability') }}</h2>
            <hr class="title-line-orange">
        </div>

        <!-- Search Form Section -->
        <div class="availability-form">
            <div>
                <label for="checkin">{{ __('messages.Check-in date') }}</label>
                <input type="date" id="checkin">
            </div>

            <div>
                <label for="checkout">{{ __('messages.Check-out date') }}</label>
                <input type="date" id="checkout">
            </div>

            <div>
                <label for="guests">{{ __('messages.People') }}</label>
                <select id="guests">
                    <option>{{ __('messages.1 Adult') }}</option>
                    <option>{{ __('messages.2 Adults') }}</option>
                    <option>{{ __('messages.3 Adults') }}</option>
                </select>
            </div>

            <button>{{ __('messages.Search') }}</button>
        </div>

        <!-- Availability Table -->
        <div class="availability-table-container">
            <table class="availability-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.Accommodation Type') }}</th>
                        <th>{{ __('messages.People') }}</th>
                        <th>{{ __('messages.Price') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ __('messages.Executive Double Room') }}</td>
                        <td>2</td>
                        <td>€270</td>
                        <td><button class="book-btn">{{ __('messages.Reserve') }}</button></td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.Deluxe Double Room') }}</td>
                        <td>2</td>
                        <td>€320</td>
                        <td><button class="booked-btn" disabled>{{ __('messages.Reserved') }}</button></td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.Suite') }}</td>
                        <td>4</td>
                        <td>€600</td>
                        <td><button class="book-btn">{{ __('messages.Reserve') }}</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Guest Reviews -->
    <section class="reviews">
        <div class="title-line-container">
            <h2>{{ __('messages.Guest Reviews') }}</h2>
            <hr class="title-line">
        </div>
        <div class="reviews-container">
            <div class="review-box">
                <div class="review-header">
                    <img src="/images/default_user_image.png" alt="{{ __('messages.User 1') }}" class="review-img">
                    <span class="user-name">John</span>
                </div>
                <p class="review-text">"{{ __('messages.Fantastic hotel with great staff!') }}"</p>
                <p class="review-excerpt">{{ __('messages.This hotel is amazing, the staff is very friendly and helpful. The amenities were top-notch and...') }}</p>
                <span class="read-more">{{ __('messages.Read More') }}</span>
            </div>
            <div class="review-box">
                <div class="review-header">
                    <img src="/images/default_user_image.png" alt="{{ __('messages.User 2') }}" class="review-img">
                    <span class="user-name">Mary</span>
                </div>
                <p class="review-text">"{{ __('messages.Beautiful location, will come again.') }}"</p>
                <p class="review-excerpt">{{ __('messages.The location of the hotel is perfect for sightseeing, and the rooms were very comfortable...') }}</p>
                <span class="read-more">{{ __('messages.Read More') }}</span>
            </div>
            <div class="review-box">
                <div class="review-header">
                    <img src="/images/default_user_image.png" alt="{{ __('messages.User 3') }}" class="review-img">
                    <span class="user-name">Alice</span>
                </div>
                <p class="review-text">"{{ __('messages.Great experience, highly recommended!') }}"</p>
                <p class="review-excerpt">{{ __('messages.I had a wonderful stay at the hotel, and everything exceeded my expectations...') }}</p>
                <span class="read-more">{{ __('messages.Read More') }}</span>
            </div>
        </div>
        <div class="reviews-buttons">
            <button class="read-all-reviews">{{ __('messages.Read All Reviews') }}</button>
            <button class="add-review"><span class="plus-icon">+</span> {{ __('messages.Add a Review') }}</button>
        </div>
    </section>

    <!-- Similar Hotels Section -->
    <section class="similar-hotels">
        <div class="title-line-container">
            <h2>{{ __('messages.Similar Hotels') }}</h2>
            <hr class="title-line-orange">
        </div>
        <div class="hotels">
            <img src="/images/condade.png" alt="{{ __('messages.Hotel 1') }}">
            <img src="/images/condade.png" alt="{{ __('messages.Hotel 2') }}">
            <img src="/images/condade.png" alt="{{ __('messages.Hotel 3') }}">
            <img src="/images/condade.png" alt="{{ __('messages.Hotel 4') }}">
        </div>
    </section>

    <x-footer />
</body>

</html>
