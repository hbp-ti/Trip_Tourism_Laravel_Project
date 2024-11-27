<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/header.css', 'resources/css/payment.css'])
</head>
<body>
   <x-header/>

    <main class="main-content">
        <section class="payment-section">
            <h1>Payment</h1>
            <div class="steps">
                <span class="step active">1</span>
                <span class="step">2</span>
                <span class="step">3</span>
            </div>
            <h2>Payment & Billing Info</h2>

            <form class="payment-form">
                <div class="payment-methods">
                    <img class="method" src="/images/mbway.png">
                    <img class="method" src="/images/multibanco.png">
                    <img class="method" src="/images/paypal.png">
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

                    <label class="awareText">
                        <input type="checkbox"> I declare I am aware of this purchase
                    </label>
					
					<button type="submit" class="continue-btn">Continue</button>
                </div>
            </form>
        </section>
    </main>

    <x-footer/>
</body>
</html>
