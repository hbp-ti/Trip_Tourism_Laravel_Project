@vite(['resources/css/footer.css'])

<footer class="footer">
    <div class="footer-section about-travel">
        <h4>About Travel</h4>
        <p>Discover tips, destinations, and inspiration to make your travel experience unforgettable.</p>
    </div>
    
    <div class="footer-section contact-info">
        <h4>Contact Information</h4>
        <a href="mailto:support@turisgo.com" class="contact-item">
            <img src="{{ asset('images/mail.png') }}" alt="Email Icon" class="icon">
            <span>support@turisgo.com</span>
        </a>
        <a href="https://maps.google.com/?q=R.+Cmte.+Pinho+e+Freitas+28,+3750-127+%C3%81gueda" target="_blank" class="contact-item">
            <img src="{{ asset('images/location.png') }}" alt="Location Icon" class="icon">
            <span>R. Cmte. Pinho e Freitas 28, 3750-127 Águeda</span>
        </a>
        <a href="tel:+351910529936" class="contact-item">
            <img src="{{ asset('images/phone.png') }}" alt="Phone Icon" class="icon">
            <span>+351 910529936</span>
        </a>
    </div>
    
    <div class="footer-section logo-and-copyright">
        <img src="{{ asset('images/estga.png') }}" alt="Logo ESTGA" class="logo">
        <div class="copyright">
            Copyright &#169 <?php echo date("Y"); ?> TurisGo. All rights reserved.
        </div>
    </div>
</footer>
