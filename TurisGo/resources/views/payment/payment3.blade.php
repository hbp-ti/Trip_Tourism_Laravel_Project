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
                <span class="step">2</span>
                <span class="step active">3</span>
            </div>
			
            <span class="subtitle">{{ __('messages.Overview') }}</span>

            <form class="payment-form">
			
                <img class="overviewServiceLogo" src="/images/multibanco.png" alt="{{ __('messages.Payment Method Logo') }}">
				
                <div class="overviewText">
                    <p>{{ __('messages.Thank you for your order. We are providing you with the information necessary to proceed with the payment:') }}</p>
                    <p>{{ __('messages.You can complete the payment through your homebanking, Service Payments, or on the ATM Network, using either your VISA/MasterCard, Visa Electron, or Multibanco card. Enter your secret code and select the operation PAYMENTS / SERVICE PAYMENT. Insert the following details:') }}</p>
                </div>
				
                <div class="overviewPaymentDetails">
					
                    <div>
                        <label for="entity">{{ __('messages.Entity') }}</label>
                        <input readonly type="text" id="entity" name="entity" value="12129">
                    </div>
					
                    <div>
                        <label for="reference">{{ __('messages.Reference') }}</label>
                        <input readonly type="text" id="reference" name="reference" value="123456789">
                    </div>
					
                    <div>
                        <label for="amount">{{ __('messages.Amount') }}</label>
                        <input readonly type="text" id="amount" name="amount" value="121,29€">
                    </div>
					
                </div>
				
                <div class="overviewInfo">
                    <p><span class="overviewInfoSymbol">&#x24D8</span>{{ __('messages.The receipt issued by the ATM serves as proof of payment. Please keep it for your records.') }}</p>
                </div>
				
                <a href="{{ route('homepage') }}" class="button buttonReturnHome">{{ __('messages.Return to Home') }}</a>
            </form>
        </section>
    </div>

    <x-footer/>
</body>
</html>
