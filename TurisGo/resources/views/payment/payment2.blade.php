<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/js/translations.js', 'resources/css/payment2.css'])

</head>

<body>
    <x-header />

    <h1 class="title">{{ __('messages.Payment') }}</h1>

    <div class="main-content">
        <section class="payment-section">
            <div class="steps">
                <div class="step">1</div>
                <div class="line"></div>
                <div class="step active">2</div>
                <div class="line"></div>
                <div class="step">3</div>
            </div>

            <div class="subtitle">{{ __('messages.Review') }}</div>

            <div class="reviewInformation">
                <div class="reviewInformationUpper">
                    <div class="info-item">
                        <div class="info-title">{{ __('messages.Item Number') }}</div>
                        <div class="info-value">{{ $cart->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-title">{{ __('messages.Type') }}</div>
                        <div class="info-value">{{ __('messages.Hotel, Tour and Tickets') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-title">{{ __('messages.Total Price') }}</div>
                        <div class="info-value">{{ $cart->total }}€</div>
                    </div>
                    <img src="{{ asset('images/payment2log.png') }}" alt="Payment Logo" class="payment-logo">
                </div>
                <div class="reviewInformationLower">
                    @foreach ($cartItems as $it)
                        @if ($it->details->type === 'Hotel')
                            <div>
                                <span class="info-title">{{ $it->details->name }}
                                    {{ $it->numb_people_hotel }}pax</span>
                                <hr>
                                <span class="info-value">{{ $it->details->total_price }}€</span>
                            </div>
                            <div>
                                <span>{{ $it->details->city }}</span>
                                <span>{{ __('messages.Checkin') }} - {{ $it->reservation_date_hotel_checkin }}</span>
                                <span>{{ __('messages.Checkout') }} -
                                    {{ $it->reservation_date_hotel_checkout }}</span>
                            </div>
                            <div>
                                <span>{{ __('messages.Accommodation Type') }} -
                                    {{ $it->details->room_type }}</span>
                            </div>
                        @elseif($it->details->type === 'Activity')
                            <div>
                                <span class="info-title">{{ $it->details->name }}
                                    {{ $it->numb_people_activity }}pax</span>
                                <hr>
                                <span class="info-value">{{ $it->details->total_price }}€</span>
                            </div>
                            <div>
                                <span>{{ $it->details->city }}</span>
                                <span>{{ __('messages.Date') }} - {{ $it->details->checkin }}</span>
                                <span>{{ __('messages.Language') }} - {{ $it->details->language }}</span>
                                <span>{{ __('messages.Duration') }} - {{ $it->details->numb_people }}</span>
                            </div>
                        @elseif($it->details->type === 'Ticket')
                            <div>
                                <span class="info-title">{{ $it->details->name }}
                                    {{ $it->details->quantity }}pax</span>
                                <hr>
                                <span class="info-value">{{ $it->details->total_price }}€</span>
                            </div>
                            <div>
                                <span>{{ $it->details->origin . '-' . $it->details->destination }}</span>
                                <span>{{ __('messages.Date') }} - {{ $it->details->departure_hour }}</span>
                                <span>{{ __('messages.Train type') }} - {{ $it->details->train_type }}</span>
                                <span>{{ __('messages.Train class') }} - {{ $it->details->train_class }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="subtitle1">{{ __('messages.Selected Payment Method') }}</div>
            <div class="selectedPaymentMethod">
                @if ($paymentMethod)
                    @if ($paymentMethod == 'mbway')
                        <img src="{{ asset('images/mbway.png') }}" alt="{{ __('messages.MB Way') }}">
                    @elseif ($paymentMethod == 'paypal')
                        <img src="{{ asset('images/paypal.png') }}" alt="{{ __('messages.PayPal') }}">
                    @elseif ($paymentMethod == 'multibanco')
                        <img src="{{ asset('images/multibanco.png') }}" alt="{{ __('messages.Multibanco') }}">
                    @endif
                @endif
                <form action="{{ route('auth.payment', ['locale' => app()->getLocale()]) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    <input type="hidden" name="phase" value="1">
                    <button type="submit" class="buttonChange">{{ __('messages.Change') }}</button>
                </form>


            </div>
            <form action="{{ route('auth.payment', ['locale' => app()->getLocale()]) }}" method="POST"
                style="display: inline;">
                @csrf
                <input type="hidden" name="phase" value="3">
                <button type="submit" class="button">{{ __('messages.Pay') }}</button>
            </form>

        </section>
    </div>
    @if (session('popup'))
    {!! session('popup') !!}
@endif
    <x-footer />
	
	<script>
	const appUrl = "{{ config('app.url') }}";
	</script>
</body>

</html>
