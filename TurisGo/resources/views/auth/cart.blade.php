<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <!-- Incluir o SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/cart.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/cart.js'])
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

            @php
                // Itens de exemplo para teste do layout
                $cartItems = [
                    (object)[
                        'id' => 1,
                        'item' => (object)[
                            'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&h=600&fit=crop',
                            'name' => 'Viagem a Paris',
                            'description' => 'Explore as ruas de Paris e a Torre Eiffel.',
                            'location' => 'Paris, França',
                            'price' => 250.00
                        ],
                        'quantity' => 2
                    ],
                    (object)[
                        'id' => 2,
                        'item' => (object)[
                            'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&h=600&fit=crop',
                            'name' => 'Passeio em Roma',
                            'description' => 'Visite o Coliseu e outros marcos históricos.',
                            'location' => 'Roma, Itália',
                            'price' => 180.00
                        ],
                        'quantity' => 1
                    ]
                ];

                $cart = (object)[
                    'subtotal' => 250*2 + 180*1 + 210*3,
                    'taxes' => 50.00,
                    'total' => (250*2 + 180*1 + 210*3) + 50.00
                ];
            @endphp

            <div class="cart-items">
                <!-- Itera os itens do carrinho dinamicamente -->
                @foreach($cartItems as $cartItem)
                <div class="cart-item">
                    <img src="{{ $cartItem->item->image }}" alt="{{ $cartItem->item->name }}">
                    <div class="item-details">
                        <h3>{{ $cartItem->item->name }}</h3>
                        <p>{{ $cartItem->item->description }}</p>
                        <p><strong>{{ $cartItem->item->location }}</strong> &nbsp&nbsp&nbsp{{ $cartItem->quantity }} {{ __('Guests') }}</p>
                    </div>
                    <p class="price">{{ $cartItem->item->price }}€</p>
                    <!-- Botão de remover com API -->
                    <form action="{{ route('auth.cart.remove', ['cartItemId' => $cartItem->id, 'locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="remove-btn">
                            <img src="{{ asset('images/removeItem.png') }}" alt="{{ __('messages.Remove') }}" style="width: 22px; height: 22px;">
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            <a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}" class="back-btn">{{ __('messages.Back to Home') }}</a>
        </div>

        <div class="summary">
            <h2>{{ __('messages.Summary') }}</h2>
            <hr>
            <ul>
                @foreach($cartItems as $cartItem)
                <li>{{ $cartItem->item->name }} <span>{{ $cartItem->item->price }}€</span></li>
                @endforeach
            </ul>
            <div class="summary-total">
                <p class="subtotal">{{ __('messages.Subtotal') }}: <span>{{ $cart->subtotal }}€</span></p>
                <p class="taxes">{{ __('messages.Taxes') }}: <span>{{ $cart->taxes }}€</span></p>
                <hr>
                <p class="total-price">{{ __('messages.Total Price') }}: <span>{{ $cart->total }}€</span></p>
                <button class="checkout-btn">{{ __('messages.Checkout') }}</button>
            </div>
        </div>
    </section>

    <!-- Tickets Section -->
    <section class="tickets">
        <div class="title-line-container tickets-section">
            <h2>{{ __('messages.Tickets') }}</h2>
            <hr class="title-line-blue">
        </div>
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
