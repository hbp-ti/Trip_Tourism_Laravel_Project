<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/contact.css', 'resources/js/contact.js'])
</head>
<body>

    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>Contact</h1>
        <p>Chat with us</p>
        </section>

    <!-- Contact Section -->
    <section class="contact-section">

        <!-- Informação com cartões -->
        <div class="contact-info-container">
            <div class="contact-card">
                <img src="{{ asset('images/locationInfo.png') }}" alt="Location Icon">
                <h3>Our Location</h3>
                <p>R. Cmte. Pinho e Freitas 28, 3750-127 Águeda</p>
            </div>
            <div class="contact-card">
                <img src="{{ asset('images/phoneInfo.png') }}" alt="Phone Icon">
                <h3>Call Us</h3>
                <p>+351 910529936</p>
            </div>
            <div class="contact-card">
                <img src="{{ asset('images/emailInfo.png') }}" alt="Email Icon">
                <h3>Email Us</h3>
                <p><a href="mailto:support@turisgo.com">support@turisgo.com</a></p>
            </div>
        </div>

        <!-- Texto fora da caixa -->
        <div class="contact-text">
            <h2>Contact Us</h2>
            <p>We’re here to help you plan your perfect trip! Whether you have questions about hotel bookings, monument visits, or tour packages, our dedicated support team is ready to assist. Please don’t hesitate to reach out for any inquiries, requests, or issues.</p>
            <p>You can contact us via email or by filling out the form below, and we’ll get back to you as soon as possible.</p>
            <p>We look forward to helping you create unforgettable travel experiences!</p>
        </div>

        <!-- Caixa do formulário -->
        <div class="contact-container">
            <form action="contact.php" method="post" class="contact-form">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Ex: John Doe" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Ex: johndoe@example.com" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>

                <button type="submit">Send</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />


</body>
</html>
