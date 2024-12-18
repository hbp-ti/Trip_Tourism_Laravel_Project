@vite(['resources/css/review.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/review.js'])
<div class="popup-overlay" id="reviewPopup">
    <div class="popup-content">
        <button class="close-popup" id="closeReviewPopup">&times;</button>
        <h2>{{ __('messages.Add a Review') }}</h2>
        <form method="POST" action="{{ route('reviews.store', ['locale' => app()->getLocale()]) }}">
            @csrf
            <label for="title">{{ __('messages.Title') }}</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">{{ __('messages.Description') }}</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="rating">{{ __('messages.Rating') }}</label>
            <select id="rating" name="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            
            <button type="submit">{{ __('messages.Submit') }}</button>
        </form>
    </div>
</div>
