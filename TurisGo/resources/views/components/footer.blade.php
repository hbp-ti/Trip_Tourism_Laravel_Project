<html lang="{{ app()->getLocale() }}">

@vite(['resources/css/footer.css'])

<footer class="footer">
    <div class="footer-section about-travel">
        <h4>{{ __('About Travel') }}</h4>
        <p>{{ __('Discover tips, destinations, and inspiration to make your travel experience unforgettable.') }}</p>
    </div>
    
    <div class="footer-section contact-info">
        <h4>{{ __('Contact Information') }}</h4>
        <a href="mailto:support@turisgo.com" class="contact-item">
            <img src="{{ asset('images/mail.png') }}" alt="{{ __('Email Icon') }}" class="icon">
            <span>support@turisgo.com</span>
        </a>
        <a href="https://maps.google.com/?q=R.+Cmte.+Pinho+e+Freitas+28,+3750-127+%C3%81gueda" target="_blank" class="contact-item">
            <img src="{{ asset('images/location.png') }}" alt="{{ __('Location Icon') }}" class="icon">
            <span>{{ __('R. Cmte. Pinho e Freitas 28, 3750-127 Águeda') }}</span>
        </a>
        <a href="tel:+351910529936" class="contact-item">
            <img src="{{ asset('images/phone.png') }}" alt="{{ __('Phone Icon') }}" class="icon">
            <span>{{ __('+351 910529936') }}</span>
        </a>
    </div>
    
    <div class="footer-section logo-and-copyright">
        <img src="{{ asset('images/estga.png') }}" alt="{{ __('Logo ESTGA') }}" class="logo">
        <div class="copyright">
            {{ __('Copyright') }} &#169; <?php echo date("Y"); ?> TurisGo. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
