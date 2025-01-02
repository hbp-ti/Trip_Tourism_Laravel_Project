<html lang="{{ app()->getLocale() }}">

@vite(['resources/js/translations.js', 'resources/css/footer.css'])

<footer class="footer">
    <div class="footer-section about-travel">
        <h4>{{ __('messages.About Travel') }}</h4>
        <p>{{ __('messages.Discover tips, destinations, and inspiration to make your travel experience unforgettable.') }}</p>
    </div>
    
    <div class="footer-section contact-info">
        <h4>{{ __('messages.Contact Information') }}</h4>
        <a href="mailto:support@turisgo.com" class="contact-item">
            <img src="{{ asset('images/mail.png') }}" alt="{{ __('messages.Email Icon') }}" class="icon">
            <span>support@turisgo.com</span>
        </a>
        <a href="https://maps.google.com/?q=R.+Cmte.+Pinho+e+Freitas+28,+3750-127+%C3%81gueda" target="_blank" class="contact-item">
            <img src="{{ asset('images/location.png') }}" alt="{{ __('messages.Location Icon') }}" class="icon">
            <span>{{ __('messages.R. Cmte. Pinho e Freitas 28, 3750-127 Águeda') }}</span>
        </a>
        <a href="tel:+351910529936" class="contact-item">
            <img src="{{ asset('images/phone.png') }}" alt="{{ __('messages.Phone Icon') }}" class="icon">
            <span>+351 910 529 936</span>
        </a>
    </div>
    
    <div class="footer-section logo-and-copyright">
        <img src="{{ asset('images/estga.png') }}" alt="{{ __('messages.Logo ESTGA') }}" class="logo">
        <div class="copyright">
            {{ __('messages.Copyright') }} &#169; <?php echo date("Y"); ?> TurisGo. {{ __('messages.All rights reserved.') }}
        </div>
    </div>
</footer>
