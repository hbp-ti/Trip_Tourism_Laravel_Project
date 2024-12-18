<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/payment2.css'])

</head>
<body>
    <x-header/>

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
                        <div class="info-value">12</div>
                    </div>
                    <div class="info-item">
                        <div class="info-title">{{ __('messages.Type') }}</div>
                        <div class="info-value">{{ __('messages.Hotel and Tour') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-title">{{ __('messages.Total Price') }}</div>
                        <div class="info-value">159€</div>
                    </div>
                    <img src="/images/payment2log.png" alt="Payment Logo" class="payment-logo">
                </div>
                <div class="reviewInformationLower">
                    <div>
                        <span class="info-title">{{ __('messages.Hotel Condado Castro') }} 2pax</span>
                        <hr>
                        <span class="info-value">121€</span>
                    </div>
                    <div>
                        <span>{{ __('messages.Lisboa') }}</span>
                        <span>{{ __('messages.Checkin') }} - 12/01/2024</span>
                        <span>{{ __('messages.Checkout') }} - 14/01/2024</span>
                    </div>
                    <div>
                        <span>{{ __('messages.Accommodation Type') }} - {{ __('messages.Executive Double Room') }}</span>
                    </div>
                    <div>
                        <span class="info-title">{{ __('messages.Full Day Tour in Coimbra') }} 1pax</span>
                        <hr>
                        <span class="info-value">38€</span>
                    </div>
                    <div>
                        <span>{{ __('messages.Coimbra') }}</span>
                        <span>{{ __('messages.Date') }} - 05/03/2024</span>
                        <span>{{ __('messages.Language') }} - {{ __('messages.Portuguese') }}</span>
                        <span>{{ __('messages.Duration') }} - 8h</span>
                    </div>
                </div>
            </div>

            <div class="subtitle1">{{ __('messages.Selected Payment Method') }}</div>
            <div class="selectedPaymentMethod">
                <img src="/images/multibanco.png" alt="{{ __('messages.Multibanco') }}">
                <button class="buttonChange">{{ __('messages.Change') }}</button>
            </div>

            <a href="{{ route('payment3', ['locale' => app()->getLocale()]) }}" class="button">{{ __('messages.Pay') }}</a>
        </section>
    </div>

    <x-footer/>
</body>
</html>