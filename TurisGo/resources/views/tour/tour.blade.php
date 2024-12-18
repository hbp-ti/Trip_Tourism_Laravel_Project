<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/tour.css'], ['resources/js/jquery-3.7.1.min.js'])
</head>

<body>
    <x-header />

    <!-- Header Section -->
    <section class="header">
        <h1>{{ $tour->name }}</h1>
    </section>

    <section class="image-slider">
        <div class="slider-images">
            @if ($tour->images && $tour->images->isNotEmpty())
                @foreach ($tour->images as $image)
                    <img src="{{ asset($image->url) }}" alt="{{ $tour->name }}"
                        class="slider-image {{ $loop->first ? '' : 'hidden' }}">
                @endforeach
            @else
                {{-- Caso não haja imagens associadas, exibe as imagens padrão --}}
                <img src="/images/imagemTesteHotel.jpg" alt="{{ __('messages.Default tour Image 1') }}" 
                    class="slider-image">
                <img src="/images/imagemTesteHotel.jpg" alt="{{ __('messages.Default tour Image 2') }}"
                    class="slider-image hidden">
                <img src="/images/imagemTesteHotel.jpg" alt="{{ __('messages.Default tour Image 3') }}"
                    class="slider-image hidden">
            @endif
        </div>
        <div class="slider-controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>
        <div class="dots-container">
            @if ($tour->images && $tour->images->isNotEmpty())
                @foreach ($tour->images as $image)
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
    <section class="tour-description">
        <p>{{ $tour->description }}</p>
        <br><br>
        <div class="location-info">
            <p><i class="fas fa-globe"></i> <strong>{{ __('messages.Country') }}:</strong> {{ $tour->country }}</p>
            <p><i class="fas fa-city"></i> <strong>{{ __('messages.City') }}:</strong> {{ $tour->city }}</p>
            <p><i class="fas fa-envelope"></i> <strong>{{ __('messages.Zip Code') }}:</strong> {{ $tour->zip_code }}
            </p>
            <p><i class="fas fa-road"></i> <strong>{{ __('messages.Street') }}:</strong> {{ $tour->street }}</p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>{{ __('messages.Coordinates') }}:</strong>
                {{ __('messages.Lat') }}: {{ $tour->lat }}, {{ __('messages.Lon') }}: {{ $tour->lon }}</p>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="facilities">
        <div class="title-line-container">
            <h2>{{ __('messages.Tour details') }}</h2>
            <hr class="title-line-blue">
        </div>
        <div class="facility-icons">
            <!-- Verificar se a instalação está disponível -->
            @if ($tour->cancel_anytime)
                <div class="icon">
                    <img src="/images/canceletour.png" alt="{{ __('messages.cancel_anytime') }}">
                    <span>{{ __('messages.cancel anytime') }}</span>
                </div>
            @endif

            @if ($tour->guide)
                <div class="icon">
                    <img src="/images/guidetour.png" alt="{{ __('messages.guide') }}">
                    <span>{{ __('messages.guide') }}</span>
                </div>
            @endif

            @if ($tour->reserve_now_pay_later)
                <div class="icon">
                    <img src="/images/reservetour.png" alt="{{ __('messages.reserve_now_pay_later') }}">
                    <span>{{ __('messages.reserve now pay later') }}</span>
                </div>
            @endif

            @if ($tour->small_groups)
                <div class="icon">
                    <img src="/images/grouptour.png" alt="{{ __('messages.small_groups') }}">
                    <span>{{ __('messages.small groups') }}</span>
                </div>
            @endif

            <div class="icon">
                <img src="/images/languagetour.png" alt="{{ __('messages.language') }}">
                <span>{{ $tour->language }}</span>
            </div>
        </div>
    </section>
    @if (session('popup'))
        {!! session('popup') !!}
    @endif
    <section class="availability">
        <div class="title-line-container">
            <h2>{{ __('messages.Availability') }}</h2>
            <hr class="title-line-orange">
        </div>
        <!-- Availability Table -->
        <div class="availability-table-container">
            <table class="availability-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.Tour Type') }}</th>
                        <th>{{ __('messages.Language') }}</th>
                        <th>{{ __('messages.Price') }}</th>
                        <th>{{ __('messages.Check-in Date') }}</th>
                        <th>{{ __('messages.Number of Guests') }}</th>
                        <th>{{ __('messages.Number of Hours') }}</th>
                        <th>{{ __('messages.Reserve') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Gerar hash combinando room_id e price_night
                        $dataToHash = $tour->id_item . '|' . $tour->price_hour;
                        $hash = hash_hmac('sha256', $dataToHash, config('app.key'));
                    @endphp
                    <tr>
                        @if ($tour)
                            <td>Tour with guide</td>
                        @else
                            <td>Tour without guide</td>
                        @endif
                        <td>{{ $tour->language }}</td>
                        <td>€{{ $tour->price_hour }}</td>
                        <td>
                            <form
                                action="{{ route('auth.cart.add', ['itemId' => $tour->id_item, 'locale' => app()->getLocale()]) }}"
                                method="POST">
                                @csrf
                                <input type="date" name="checkin_date[{{ $tour->id_item }}]" class="custom-input"
                                    required>
                        </td>
                        <td>
                            <select name="guests[{{ $tour->id_item }}]" class="custom-select" required>
                                <option value="1">{{ __('messages.1 Adult') }}</option>
                                <option value="2">{{ __('messages.2 Adults') }}</option>
                                <option value="3">{{ __('messages.3 Adults') }}</option>
                            </select>
                        </td>
                        <td>
                            <select name="hours[{{ $tour->id_item }}]" class="custom-select" required>
                                <option value="1">{{ __('messages.1 Hour') }}</option>
                                <option value="2">{{ __('messages.2 Hours') }}</option>
                                <option value="3">{{ __('messages.3 Hours') }}</option>
                                <option value="4">{{ __('messages.4 Hours') }}</option>
                                <option value="5">{{ __('messages.5 Hours') }}</option>
                                <option value="6">{{ __('messages.6 Hours') }}</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="item_hash[{{ $tour->id_item }}]" value="{{ $hash }}">
                            <button class="book-btn">{{ __('messages.Reserve') }}</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Guest Reviews -->
    <section class="reviews">
        <div class="title-line-container">
            <h2>{{ __('messages.Guest Reviews') }}</h2>
            <hr class="title-line-blue">
        </div>
        <div class="reviews-container">
            @foreach ($tour->reviews as $review)
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
            <button class="add-review" id="openReviewPopup">
                <span class="plus-icon">+</span> {{ __('messages.Add a Review') }}
            </button>
            <x-review />
        </div>
    </section>
    <x-footer />
</body>

</html>
