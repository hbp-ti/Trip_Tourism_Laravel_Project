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

    <section class="cart-content">
        <div class="shopping-cart">
            <h2>Shopping Cart</h2>
            <div class="cart-items">
                @foreach($cartItems as $cartItem)
                <div class="cart-item">
                    <img src="{{ asset('images/' . $cartItem->item->image) }}" alt="{{ $cartItem->item->name }}">
                    <div class="item-details">
                        <h3>{{ $cartItem->item->name }}</h3>
                        <p>{{ $cartItem->item->description }}</p>
                        <p><strong>{{ $cartItem->item->location }}</strong> | {{ $cartItem->quantity }} Guests</p>
                    </div>
                    <p class="price">{{ $cartItem->item->price }}€</p>
                    <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="remove-btn">Remove</button>
                    </form>
                </div>
                @endforeach
            </div>

            <a href="{{ route('homepage') }}" class="back-btn">Back to Home</a>
        </div>

        <div class="summary">
            <h2>Summary</h2>
            <ul>
                @foreach($cartItems as $cartItem)
                <li>{{ $cartItem->item->name }} <span>{{ $cartItem->item->price }}€</span></li>
                @endforeach
            </ul>
            <hr>
            <p class="subtotal">Subtotal: <span>{{ $cart->subtotal }}€</span></p>
            <p class="taxes">Taxes: <span>{{ $cart->taxes }}€</span></p>
            <hr>
            <p class="total-price">Total Price: <span>{{ $cart->total }}€</span></p>
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