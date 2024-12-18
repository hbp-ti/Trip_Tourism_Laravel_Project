<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel->name }} - TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/hotel_details.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/hotel_details.js'])
</head>

<body>
    <x-header />

    <!-- Header Section -->
    <section class="header">
        <h1>{{ $hotel->name }}</h1>
    </section>

    <!-- Image Slider -->
    <section class="image-slider">
        <div class="slider-images">
            @if ($hotel->images && $hotel->images->isNotEmpty())
                @foreach ($hotel->images as $image)
                    <img src="{{ asset($image->url) }}" alt="{{ $hotel->name }}"
                        class="slider-image {{ $loop->first ? '' : 'hidden' }}">
                @endforeach
            @else
                {{-- Caso não haja imagens associadas, exibe as imagens padrão --}}
                <img src="/images/imagemTesteHotel.jpg" alt="{{ __('messages.Default Hotel Image 1') }}"
                    class="slider-image">
                <img src="/images/imagemTesteHotel.jpg" alt="{{ __('messages.Default Hotel Image 2') }}"
                    class="slider-image hidden">
                <img src="/images/imagemTesteHotel.jpg" alt="{{ __('messages.Default Hotel Image 3') }}"
                    class="slider-image hidden">
            @endif
        </div>
        <div class="slider-controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>
        <div class="dots-container">
            @if ($hotel->images && $hotel->images->isNotEmpty())
                @foreach ($hotel->images as $image)
                    <span class="dot {{ $loop->first ? 'active-dot' : '' }}"></span>
                @endforeach
            @else
                {{-- Caso não haja imagens associadas, exibe os dots padrão --}}
                <span class="dot active-dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            @endif
        </div>
    </section>


    <!-- Description Section -->
    <section class="hotel-description">
        <p>{{ $hotel->description }}</p>
        <br><br>
        <div class="location-info">
            <p><i class="fas fa-globe"></i> <strong>{{ __('messages.Country') }}:</strong> {{ $hotel->country }}</p>
            <p><i class="fas fa-city"></i> <strong>{{ __('messages.City') }}:</strong> {{ $hotel->city }}</p>
            <p><i class="fas fa-envelope"></i> <strong>{{ __('messages.Zip Code') }}:</strong> {{ $hotel->zip_code }}
            </p>
            <p><i class="fas fa-road"></i> <strong>{{ __('messages.Street') }}:</strong> {{ $hotel->street }}</p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>{{ __('messages.Coordinates') }}:</strong>
                {{ __('messages.Lat') }}: {{ $hotel->lat }}, {{ __('messages.Lon') }}: {{ $hotel->lon }}</p>
        </div>
    </section>


    <!-- Facilities Section -->
    <section class="facilities">
        <div class="title-line-container hotel-section">
            <h2>{{ __('messages.Facilities') }}</h2>
            <hr class="title-line-blue">
        </div>
        <div class="facility-icons">
            <!-- Verificar se a instalação está disponível -->
            @if ($hotel->free_wifi)
                <div class="icon">
                    <img src="/images/wifi_free_icon.png" alt="{{ __('messages.WiFi') }}">
                    <span>{{ __('messages.Free WiFi') }}</span>
                </div>
            @endif

            @if ($hotel->pool)
                <div class="icon">
                    <img src="/images/pool_icon.png" alt="{{ __('messages.Pool') }}">
                    <span>{{ __('messages.Pool') }}</span>
                </div>
            @endif

            @if ($hotel->bar)
                <div class="icon">
                    <img src="/images/bar_icon.png" alt="{{ __('messages.Bar') }}">
                    <span>{{ __('messages.Bar') }}</span>
                </div>
            @endif

            @if ($hotel->parking)
                <div class="icon">
                    <img src="/images/parking_icon.png" alt="{{ __('messages.Parking') }}">
                    <span>{{ __('messages.Free Parking') }}</span>
                </div>
            @endif

            @if ($hotel->non_smoking_rooms)
                <div class="icon">
                    <img src="/images/no_smoking_icon.png" alt="{{ __('messages.Non-smoking rooms') }}">
                    <span>{{ __('messages.Non-smoking rooms') }}</span>
                </div>
            @endif
        </div>
    </section>


    <!-- Availability Section -->
    <section class="availability">
        <div class="title-line-container hotel-section">
            <h2>{{ __('messages.Availability') }}</h2>
            <hr class="title-line-orange">
        </div>

        @if (session('popup'))
            {!! session('popup') !!}
        @endif
        <div class="availability-table-container">
            <table class="availability-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.Accommodation Type') }}</th>
                        <th>{{ __('messages.Bed Count') }}</th>
                        <th>{{ __('messages.Price') }}</th>
                        <th>{{ __('messages.Check-in Date') }}</th>
                        <th>{{ __('messages.Checkout Date') }}</th>
                        <th>{{ __('messages.Number of Guests') }}</th>
                        <th>{{ __('messages.Reserve') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hotel->rooms as $room)
                        @php
                            // Gerar hash combinando room_id e price_night
                            $dataToHash = $room->id . '|' . $room->price_night;
                            $hash = hash_hmac('sha256', $dataToHash, config('app.key'));
                        @endphp
                        <tr>
                            <td>{{ $room->type }}</td>
                            <td>{{ $room->bed_count }}</td>
                            <td>€{{ $room->price_night }}</td>
                            <td>
                                <form
                                    action="{{ route('auth.cart.add', ['itemId' => $hotel->id_item, 'locale' => app()->getLocale()]) }}"
                                    method="POST">
                                    @csrf
                                    <input type="date" name="checkin_date[{{ $room->id }}]" class="custom-input"
                                        required>
                            </td>
                            <td>
                                <input type="date" name="checkout_date[{{ $room->id }}]" class="custom-input"
                                    required>
                            </td>
                            <td>
                                <select name="guests[{{ $room->id }}]" class="custom-select" required>
                                    <option value="1">{{ __('messages.1 Adult') }}</option>
                                    <option value="2">{{ __('messages.2 Adults') }}</option>
                                    <option value="3">{{ __('messages.3 Adults') }}</option>
                                </select>
                            </td>
                            <td>
                                @if ($room->available)
                                    <!-- Adiciona o hash e o room_id como inputs hidden -->
                                    <input type="hidden" name="item_hash[{{ $room->id }}]"
                                        value="{{ $hash }}">
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <button type="submit" class="book-btn">
                                        {{ __('messages.Reserve') }}
                                    </button>
                                @else
                                    <button class="booked-btn" disabled>{{ __('messages.Reserved') }}</button>
                                @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Guest Reviews -->
    <section class="reviews">
        <div class="title-line-container hotel-section">
            <h2>{{ __('messages.Guest Reviews') }}</h2>
            <hr class="title-line-blue">
        </div>
        <div class="reviews-container">
            @foreach ($hotel->reviews as $review)
                <div class="review-box">
                    <div class="review-header">
                        <img src="{{ $review->user->image ?? asset('images/default_user_image.png') }}"
                            alt="{{ $review->user->first_name . $review->user->last_name }}" class="review-img">
                        <span class="user-name">{{ $review->user->first_name . $review->user->last_name }}</span>
                    </div>
                    <p class="review-text">"{{ $review->title }}"</p>
                    <p class="review-excerpt">{{ $review->description }}</p>
                    <span class="read-more">{{ __('messages.Read More') }}</span>
                </div>
            @endforeach
        </div>
        <div class="reviews-buttons">
            <button class="read-all-reviews">{{ __('messages.Read All Reviews') }}</button>
            <button class="add-review"><span class="plus-icon">+</span> {{ __('messages.Add a Review') }}</button>
            <x-review />
        </div>
    </section>

    <!-- Similar Hotels Section -->
    <section class="similar-hotels">
        <div class="title-line-container">
            <h2>{{ __('messages.Similar Hotels') }}</h2>
            <hr class="title-line-orange">
        </div>
        <div class="hotels">
            @foreach ($similarHotels as $similarHotel)
                <img src="{{ $similarHotel->image_url ?? asset('images/default-hotel.jpg') }}"
                    alt="{{ $similarHotel->name }}">
            @endforeach
        </div>
    </section>

    <x-footer />
</body>

</html>
