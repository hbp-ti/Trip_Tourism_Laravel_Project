<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - TurisGo</title>
    @vite(['resources/css/contact.css'])
</head>
<body>

    <!-- Header -->
    <x-header />

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-header">
            <h1>Contact</h1>
            <p>Chat with us</p>
        </div>

        <!-- Texto fora da caixa -->
        <div class="contact-text">
            <h2>Contact Us</h2>
            <p>We’re here to help you plan your perfect trip! Whether you have questions about hotel bookings, monument visits, or tour packages, our dedicated support team is ready to assist. Please don’t hesitate to reach out for any inquiries, requests, or issues.</p>
            <p>You can contact us via email at <a href="mailto:support@turisgo.com">support@turisgo.com</a> or by filling out the form below, and we’ll get back to you as soon as possible.</p>
            <p>We look forward to helping you create unforgettable travel experiences!</p>
        </div>

        <!-- Caixa do formulário -->
        <div class="contact-container">
            <form action="contact.php" method="post" class="contact-form">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Hugo Bessa Pereira" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="hbp@ua.pt" required>

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
