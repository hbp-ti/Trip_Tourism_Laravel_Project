<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/payment.css'])
</head>
<body>
   <x-header/>

    <h1 class="title">{{ __('Payment') }}</h1>

    <div class="main-content">
        <section class="payment-section">
            
            <div class="steps">
                <span class="step">1</span>
                <span class="step active">2</span>
                <span class="step">3</span>
            </div>
			
            <span class="subtitle">{{ __('Review') }}</span>

            <form class="payment-form">
                <div class="reviewInformation">
                    <div class="reviewInformationUpper">
						<div class="itemNumber">
							<div class="info-title">{{ __('Item Number') }}</div>
							<div class="info-value">12</div>
						</div>
						<div class="type">
							<div class="info-title">{{ __('Type') }}</div>
							<div class="info-value">{{ __('Hotel and Tour') }}</div>
						</div>
						<div class="totalPrice">
							<div class="info-title">{{ __('Total Price') }}</div>
							<div class="info-value">159€</div>
						</div>
						<div class="iconPurchaseClass">
							<img src="/images/iconPurchase.png" alt="{{ __('Purchase Icon') }}">
						</div>
                    </div>
                    
                    <div class="reviewInformationLower">
                        <div class="info-title">{{ __('Hotel Condado Castro - 2pax - 100€') }}</div>
						<hr>
                        <div class="info-value">
                            {{ __('Lisboa') }}&emsp;&emsp;&emsp;
                            {{ __('Checkin') }} - 12/01/2024&emsp;&emsp;&emsp;
                            {{ __('Checkout') }} - 14/01/2024
                            <br>
                            {{ __('Accommodation Type') }} - {{ __('Executive Double Room') }}
                        </div>
                        <br>
						
                        <div class="info-title">{{ __('Full Day Tour in Coimbra - 1pax - 59€') }}</div>
						<hr>
                        <div class="info-value">
                            {{ __('Coimbra Date') }} - 05/03/2024&emsp;&emsp;&emsp;
                            {{ __('Language') }} - {{ __('Portuguese') }}&emsp;&emsp;&emsp;
                            {{ __('Duration') }} - 8h
                        </div>
                    </div>
                    
                    <div class="paymentMethod">
                        <img src="/images/multibanco.png" alt="{{ __('Multibanco') }}">
                        <a href="{{ route('payment1') }}" class="button buttonChange">{{ __('Change') }}</a>
                    </div>

                    <a href="{{ route('payment3') }}" class="button buttonPay">{{ __('Pay') }}</a>
                </div>
            </form>
        </section>
    </div>

    <x-footer/>
</body>
</html>
