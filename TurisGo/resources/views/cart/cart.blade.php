<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    @vite(['resources/css/cart.css'])
</head>
<body>
    <!-- Main Header -->
    <x-header />

    <!-- Cart Page Specific Header -->
    <section class="cart-header">
        <div class="overlay">
            <div class="cart-header-content">
                <h1>Shopping Cart</h1>
                <p>Your journey is just a click away!</p>
            </div>
        </div>
    </section>

    <!-- Main Cart Content -->
    <section class="cart-content">
        <div class="shopping-cart">
            <h2>Shopping Cart</h2>
            <div class="cart-items">
                <div class="cart-item">
                    <img src="{{ asset('images/hotelcondado.png') }}" alt="Condado Castro Hotel">
                    <div class="item-details">
                        <h3>Hotel Condado Castro</h3>
                        <p>Executive Double Room</p>
                        <p><strong>Lisbon</strong> | 2 Guests</p>
                    </div>
                    <p class="price">121,00€</p>
                    <button class="remove-btn">X</button>
                </div>

                <div class="cart-item">
                    <img src="{{ asset('images/hoteliberico.png') }}" alt="Iberian Hotel">
                    <div class="item-details">
                        <h3>Hotel Ibérico</h3>
                        <p>Deluxe Double Room</p>
                        <p><strong>Aveiro</strong> | 1 Hóspede</p>
                        </div>
                    <p class="price">98,00€</p>
                    <button class="remove-btn">X</button>
                </div>

                <div class="cart-item">
                    <img src="{{ asset('images/tourfullday.png') }}" alt="Tour de Dia Inteiro">
                    <div class="item-details">
                        <h3>Full Day Tour in Coimbra</h3>
                        <p>Guide</p>
                        <p><strong>Coimbra</strong> | 3 Guests</p>
                    </div>
                    <p class="price">38,00€</p>
                    <button class="remove-btn">X</button>
                </div>
            </div>

            <a href="#" class="back-btn">Back to Home</a>
        </div>

        <div class="summary">
            <h2>Summary</h2>
            <ul>
                <li>Hotel Condado Castro <span>121,00€</span></li>
                <li>Hotel Ibérico <span>98,00€</span></li>
                <li>Tour de Dia Inteiro em Coimbra <span>38,00€</span></li>
            </ul>
            <hr>
            <p class="subtotal">Subtotal: <span>257,00€</span></p>
            <p class="taxes">Taxes: <span>0€</span></p>
            <hr>
            <p class="total-price">Total Price: <span>257,00€</span></p>
            <button class="checkout-btn">Checkout</button>
        </div>
    </section>

    <!-- Tickets Section -->
    <section class="tickets">
        <h2>Tickets</h2>
        <p>Your journey is almost ready! Add train or bus tickets for a convenient trip. Choose the best option and make the most of your journey!</p>
        <div class="ticket-buttons">
            <button class="train-btn">Buy Train Tickets</button>
            <button class="bus-btn">Buy Bus Tickets</button>
        </div>
    </section>

    <!-- Rodapé Principal -->
    <x-footer />
</body>
</html>