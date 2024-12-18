<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    @vite(['resources/css/review.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/review.js'])
</head>
<body>
    <div class="popup-overlay" id="reviewPopup">
        <div class="popup-content">
            <button class="close-popup" id="closeReviewPopup">&times;</button>
            <h2>{{ __('messages.Add a Review') }}</h2>
            <form method="POST" action="{{ route('reviews.store', ['locale' => app()->getLocale()]) }}">
                @csrf
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                
                <label for="title">{{ __('messages.Title') }}</label>
                <input type="text" id="title" name="title" required>
                
                <label for="description">{{ __('messages.Description') }}</label>
                <textarea id="description" name="description" required></textarea>
                
                <button type="submit">{{ __('messages.Submit') }}</button>
            </form>
        </div>
    </div>
</body>
</html>