<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/cart.css'])
</head>

<body>
    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Shopping Cart') }}</h1>
        <p>{{ __('messages.Your journey is just a click away') }}</p>
    </section>

    <!-- Main Cart Content -->
    <section class="cart-content">
        <div class="shopping-cart">
            <h2>{{ __('messages.Shopping Cart') }}</h2>
            <div class="cart-items">
                <!-- Itera os itens do carrinho dinamicamente -->
                @foreach($cartItems as $cartItem)
                <div class="cart-item">
                    <img src="{{ asset('images/' . $cartItem->item->image) }}" alt="{{ $cartItem->item->name }}">
                    <div class="item-details">
                        <h3>{{ $cartItem->item->name }}</h3>
                        <p>{{ $cartItem->item->description }}</p>
                        <p><strong>{{ $cartItem->item->location }}</strong> | {{ $cartItem->quantity }} {{ __('messages.Guests') }}</p>
                    </div>
                    <p class="price">{{ $cartItem->item->price }}€</p>
                    <!-- Botão de remover com API -->
                    <form action="{{ route('auth.cart.remove', ['cartItemId' => $cartItem->id, 'locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="remove-btn">X</button>
                    </form>
                </div>
                @endforeach
            </div>

            <a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}" class="back-btn">{{ __('messages.Back to Home') }}</a>
        </div>

        <div class="summary">
            <h2>{{ __('messages.Summary') }}</h2>
            <ul>
                @foreach($cartItems as $cartItem)
                <li>{{ $cartItem->item->name }} <span>{{ $cartItem->item->price }}€</span></li>
                @endforeach
            </ul>
            <hr>
            <p class="subtotal">{{ __('messages.Subtotal') }}: <span>{{ $cart->subtotal }}€</span></p>
            <p class="taxes">{{ __('messages.Taxes') }}: <span>{{ $cart->taxes }}€</span></p>
            <hr>
            <p class="total-price">{{ __('messages.Total Price') }}: <span>{{ $cart->total }}€</span></p>
            <button class="checkout-btn">{{ __('messages.Checkout') }}</button>
        </div>
    </section>

    <!-- Tickets Section -->
    <section class="tickets">
        <h2>{{ __('messages.Tickets') }}</h2>
        <p>{{ __('messages.Your journey is almost ready! Add train or bus tickets for a convenient trip. Choose the best option and make the most of your journey!') }}</p>
        <div class="ticket-buttons">
            <button class="train-btn">{{ __('messages.Buy Train Tickets') }}</button>
            <button class="bus-btn">{{ __('messages.Buy Bus Tickets') }}</button>
        </div>
    </section>

    <!-- Rodapé Principal -->
    <x-footer />
</body>

</html>
