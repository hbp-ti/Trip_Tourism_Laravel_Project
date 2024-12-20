<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/payment3.css'])
</head>

<body>
    <x-header />

    <h1 class="title">{{ __('messages.Payment') }}</h1>

    <div class="main-content">
        <section class="payment-section">
            <div class="steps">
                <div class="step">1</div>
                <div class="line"></div>
                <div class="step">2</div>
                <div class="line"></div>
                <div class="step active">3</div>
            </div>

            <div class="content-box">
                @if ($paymentMethod === 'mbway')
                    <img class="overview-logo" src="/images/mbway.png" alt="{{ __('messages.MB Way') }}">
                @elseif ($paymentMethod === 'multibanco')
                    <img class="overview-logo" src="/images/multibanco.png" alt="{{ __('messages.Multibanco') }}">
                @elseif ($paymentMethod === 'paypal')
                    <img class="overview-logo" src="/images/paypal.png" alt="{{ __('messages.PayPal') }}">
                @endif

                @if ($paymentMethod === 'mbway')
                    <h2 class="subtitle">{{ __('messages.Mbway (Purchase/Service Payment)') }}</h2>
                @elseif ($paymentMethod === 'multibanco')
                    <h2 class="subtitle">{{ __('messages.Multibanco (Purchase/Service Payment)') }}</h2>
                @elseif ($paymentMethod === 'paypal')
                    <h2 class="subtitle">{{ __('messages.Paypal (Purchase/Service Payment)') }}</h2>
                @endif
                <div class="overview-text">
                    <p>{{ __('messages.Thank you for your order. We are providing you with the information necessary to proceed with the payment.') }}
                    </p>
                    <p>{{ __('messages.You can complete the payment through your homebanking, Service Payments, or on the ATM Network. Insert the following details:') }}
                    </p>
                </div>

                @if ($paymentMethod == 'multibanco')
                    <div class="payment-details">
                        <div class="payment-item">
                            <span class="label">{{ __('messages.Entity') }}</span>
                            <span class="value">12129</span>
                        </div>
                        <div class="payment-item">
                            <span class="label">{{ __('messages.Reference') }}</span>
                            <span class="value">123 456 789</span>
                        </div>
                        <div class="payment-item">
                            <span class="label">{{ __('messages.Amount') }}</span>
                            <span class="value">123,67€</span>
                        </div>
                    </div>
                @elseif($paymentMethod == 'mbway')
                    <div class="payment-details">
                        <div class="payment-item">
                            <span class="label">{{ __('messages.Number') }}</span>
                            <span class="value"></span>
                        </div>
                    </div>
                @elseif($paymentMethod == 'paypal')
                    <div class="payment-details">
                        <div class="payment-item">
                            <span class="label">{{ __('messages.Paypal') }}</span>
                            <button type="button" class="buttonChange"
                                onclick="openPopup('https://www.paypal.com/signin', 'PayPal Login', 800, 600)">
                                {{ __('messages.PayPal') }}
                            </button>

                        </div>
                    </div>
                @endif

                <p class="info">
                    <img src="/images/carepayment3.png" alt="{{ __('messages.Info Icon') }}" class="info-icon">
                    {{ __('messages.The receipt issued by the ATM serves as proof of payment. Please keep it for your records.') }}
                </p>
            </div>

            <a href="{{ route('homepage', ['locale' => app()->getLocale()]) }}"
                class="button">{{ __('messages.Return to Home') }}</a>
        </section>
    </div>

    <x-footer />

</body>

</html>
