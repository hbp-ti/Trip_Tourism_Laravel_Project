<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/header.css', 'resources/css/payment.css', 'resources/js/payment.js'])
</head>
<body>
   <x-header/>

	<h1 class="title">Payment</h1>

    <div class="main-content">
        <section class="payment-section">
            <div class="steps">
                <span class="step active">1</span>
                <span class="step">2</span>
                <span class="step">3</span>
            </div>
			
            <h2 class="subtitle">Payment & Billing Info</h2>

            <form class="payment-form">
				<div class="title-line-container">
					<span class="titleWithHr">Payment Method</span>
					<hr class="title-line-orange">
				</div>

                <div class="payment-methods">
                    <div class="method">
                        <img class="mbway" src="/images/mbway.png">
                    </div>
                    <div class="method">
                        <img class="multibanco" src="/images/multibanco.png">
                    </div>
                    <div class="method">
                        <img class="paypal" src="/images/paypal.png">
                    </div>
                </div>

				<div class="title-line-container">
					<span class="titleWithHr">Billing Information</span>
					<hr class="title-line-blue">
				</div>

                <div class="billing-info">
					<label class="paymentTextInputs" for="address">Billing address</label>
					<input class="paymentTextInputs" type="text" id="address" placeholder="">

					<label class="paymentTextInputs" for="address2">Billing address, line 2</label>
					<input class="paymentTextInputs" type="text" id="address2" placeholder="">

					<label class="paymentTextInputs" for="city">City</label>
					<input class="paymentTextInputs" type="text" id="city" placeholder="">

					<label class="paymentTextInputs" for="zip">Zip or postal code</label>
					<input class="paymentTextInputs" type="text" id="zip" placeholder="">

					<label for="country">Country</label>
					<select class="paymentTextInputs" id="country">
						<option value="Portugal">Portugal</option>
						<option value="United Kingdom">United Kingdom</option>
					</select>

                    <div class="awareCheckBox">
                        <label class="awareText">
                            <label class="switch">
                                <input type="checkbox" name="aware" id="aware">
                                <span class="slider"></span>
                            </label>
                            <span>I declare I am aware of this purchase</span>
                        </label>
                    </div>
					
					<a href="{{ route('payment2') }}" class="button buttonContinue">Continue</a>
                </div>
            </form>
        </section>
    </div>

    <x-footer/>
</body>
</html>
