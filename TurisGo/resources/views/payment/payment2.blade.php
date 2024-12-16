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

    <h1 class="title">{{ __('messages.Payment') }}</h1>

    <div class="main-content">
        <section class="payment-section">
            
            <div class="steps">
                <span class="step">1</span>
                <span class="step active">2</span>
                <span class="step">3</span>
            </div>
			
            <span class="subtitle">{{ __('messages.Review') }}</span>

            <form class="payment-form">
                <div class="reviewInformation">
                    <div class="reviewInformationUpper">
						<div class="itemNumber">
							<div class="info-title">{{ __('messages.Item Number') }}</div>
							<div class="info-value">12</div>
						</div>
						<div class="type">
							<div class="info-title">{{ __('messages.Type') }}</div>
							<div class="info-value">{{ __('messages.Hotel and Tour') }}</div>
						</div>
						<div class="totalPrice">
							<div class="info-title">{{ __('messages.Total Price') }}</div>
							<div class="info-value">159€</div>
						</div>
						<div class="iconPurchaseClass">
							<img src="/images/iconPurchase.png" alt="{{ __('messages.Purchase Icon') }}">
						</div>
                    </div>
                    
                    <div class="reviewInformationLower">
                        <div class="info-title">{{ __('messages.Hotel Condado Castro - 2pax - 100€') }}</div>
						<hr>
                        <div class="info-value">
                            {{ __('messages.Lisboa') }}&emsp;&emsp;&emsp;
                            {{ __('messages.Checkin') }} - 12/01/2024&emsp;&emsp;&emsp;
                            {{ __('messages.Checkout') }} - 14/01/2024
                            <br>
                            {{ __('messages.Accommodation Type') }} - {{ __('messages.Executive Double Room') }}
                        </div>
                        <br>
						
                        <div class="info-title">{{ __('messages.Full Day Tour in Coimbra - 1pax - 59€') }}</div>
						<hr>
                        <div class="info-value">
                            {{ __('messages.Coimbra Date') }} - 05/03/2024&emsp;&emsp;&emsp;
                            {{ __('messages.Language') }} - {{ __('messages.Portuguese') }}&emsp;&emsp;&emsp;
                            {{ __('messages.Duration') }} - 8h
                        </div>
                    </div>
                    
                    <div class="paymentMethod">
                        <img src="/images/multibanco.png" alt="{{ __('messages.Multibanco') }}">
                        <a href="{{ route('payment1', ['locale' => app()->getLocale()]) }}" class="button buttonChange">{{ __('messages.Change') }}</a>
                    </div>

                    <a href="{{ route('payment3', ['locale' => app()->getLocale()]) }}" class="button buttonPay">{{ __('messages.Pay') }}</a>
                
					<br><br>
				</div>
            </form>
        </section>
    </div>

    <x-footer/>
</body>
</html>
