<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/header.css', 'resources/css/payment.css', 'resources/js/payment.js'])
</head>
<body>
   <x-header/>

    <h1 class="title">{{ __('messages.Payment') }}</h1>

    <div class="main-content">
        <section class="payment-section">
            <div class="steps">
                <span class="step active">1</span>
                <span class="step">2</span>
                <span class="step">3</span>
            </div>
			
            <h2 class="subtitle">{{ __('messages.Payment & Billing Info') }}</h2>

            <form class="payment-form">
				<div class="title-line-container">
					<span class="titleWithHr">{{ __('messages.Payment Method') }}</span>
					<hr class="title-line-orange">
				</div>

                <div class="payment-methods">
                    <div class="method">
                        <img class="mbway" src="/images/mbway.png" alt="{{ __('messages.MB Way') }}">
                    </div>
                    <div class="method">
                        <img class="multibanco" src="/images/multibanco.png" alt="{{ __('messages.Multibanco') }}">
                    </div>
                    <div class="method">
                        <img class="paypal" src="/images/paypal.png" alt="{{ __('messages.PayPal') }}">
                    </div>
                </div>

				<div class="title-line-container">
					<span class="titleWithHr">{{ __('messages.Billing Information') }}</span>
					<hr class="title-line-blue">
				</div>

                <div class="billing-info">
					<label class="paymentTextInputs" for="address">{{ __('messages.Billing address') }}</label>
					<input class="paymentTextInputs" type="text" id="address" placeholder="{{ __('messages.Enter your billing address') }}">

					<label class="paymentTextInputs" for="address2">{{ __('messages.Billing address, line 2') }}</label>
					<input class="paymentTextInputs" type="text" id="address2" placeholder="{{ __('messages.Additional address information') }}">

					<label class="paymentTextInputs" for="city">{{ __('messages.City') }}</label>
					<input class="paymentTextInputs" type="text" id="city" placeholder="{{ __('messages.Enter your city') }}">

					<label class="paymentTextInputs" for="zip">{{ __('messages.Zip or postal code') }}</label>
					<input class="paymentTextInputs" type="text" id="zip" placeholder="{{ __('messages.Enter your postal code') }}">

					<label for="country">{{ __('messages.Country') }}</label>
					<select class="paymentTextInputs" id="country">
						<option value="Portugal">{{ __('messages.Portugal') }}</option>
						<option value="United Kingdom">{{ __('messages.United Kingdom') }}</option>
					</select>

                    <div class="awareCheckBox">
                        <label class="awareText">
                            <label class="switch">
                                <input type="checkbox" name="aware" id="aware">
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('messages.I declare I am aware of this purchase') }}</span>
                        </label>
                    </div>
					
					<a href="{{ route('payment2', ['locale' => app()->getLocale()]) }}" class="button buttonContinue">{{ __('messages.Continue') }}</a>
                </div>
            </form>
        </section>
    </div>

    <x-footer/>
</body>
</html>
