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

            <div class="cart-items">
                <!-- Itera os itens do carrinho dinamicamente -->
                @foreach ($cartItems as $cartItem)
                    <div class="cart-item">
                        <img src="{{ $cartItem->item->image }}" alt="{{ $cartItem->item->name }}">
                        <div class="item-details">
                            <h3>{{ $cartItem->details->name }}</h3>
                            <p>{{ $cartItem->details->description }}</p>
                            <p><strong>{{ $cartItem->details->city . ', ' . $cartItem->details->country }}</strong>
                                &nbsp&nbsp&nbsp
                                @if ($cartItem->details->type === 'Hotel')
                                    <p>{{ $cartItem->numb_people_hotel }} {{ __('Guests') }}</p>
                                @elseif ($cartItem->details->type === 'Activity')
                                    <p>{{ $cartItem->numb_people_activity }} {{ __('Guests') }}</p>
                                @elseif ($cartItem->details->type === 'Ticket')
                                    <p>{{ $cartItem->train_people_count }} {{ __('Guests') }}</p>
                                @else
                                    <p>{{ __('N/A') }}</p>
                                @endif
                            </p>
                        </div>
                        <p class="price">{{ $cartItem->details->subtotal }}€</p>
                        <!-- Botão de remover com API -->
                        <form
                            action="{{ route('auth.cart.remove', ['cartItem' => urlencode(json_encode($cartItem)), 'locale' => app()->getLocale()]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="remove-btn">
                                <img src="{{ asset('images/removeItem.png') }}" alt="{{ __('messages.Remove') }}"
                                    style="width: 22px; height: 22px;">
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}"
                class="back-btn">{{ __('messages.Back to Home') }}</a>
        </div>

        <div class="summary">
            <h2>{{ __('messages.Summary') }}</h2>
            <hr>
            <ul>
                @foreach ($cartItems as $cartItem)
                    <li>{{ $cartItem->details->name }} <span>
                            @if ($cartItem->details->type === 'Hotel')
                                {{ $cartItem->details->subtotal }}€
                            @elseif ($cartItem->details->type === 'Activity')
                                {{ $cartItem->details->subtotal }}€
                            @elseif ($cartItem->details->type === 'Ticket')
                                {{ $cartItem->details->subtotal }}€
                            @else
                                <p>{{ __('N/A') }}</p>
                            @endif
                        </span></li>
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
        <p>{{ __('messages.Your journey is almost ready! Add train or bus tickets for a convenient trip. Choose the best option and make the most of your journey!') }}
        </p>
        <div class="ticket-buttons">
            <a href="{{ route('auth.tickets', ['locale' => app()->getLocale()]) }}"
                class="ticket-btn">{{ __('messages.Buy Tickets') }}</a>
        </div>
    </section>
    @if (session('popup'))
        {!! session('popup') !!}
    @endif
    <!-- Rodapé Principal -->
    <x-footer />
</body>

</html>
