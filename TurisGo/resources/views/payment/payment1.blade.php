<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/header.css', 'resources/css/payment.css','resources/js/jquery-3.7.1.min.js', 'resources/js/payment.js'])
</head>
<body>
   <x-header/>

    <h1 class="title">{{ __('messages.Payment') }}</h1>

    <div class="main-content">
        <section class="payment-section">
            <div class="steps">
                <div class="step active"><span>1</span></div>
                <div class="line"></div>
                <div class="step"><span>2</span></div>
                <div class="line"></div>
                <div class="step"><span>3</span></div>
            </div>

            <h2 class="subtitle">{{ __('messages.Payment & Billing Info') }}</h2>

            <form class="payment-form" method="POST" action="{{ route('auth.payment', ['phase' => 2, 'locale' => app()->getLocale()]) }}">
                @csrf
                <div class="title-line-container">
                    <span class="titleWithHr">{{ __('messages.Payment Method') }}</span>
                    <hr class="title-line-orange">
                </div>
                <!-- Payment Methods -->    
                <div class="payment-methods">
                    <div class="method" id="mbway" >
                        <img class="mbway" src="/images/mbway.png" alt="{{ __('messages.MB Way') }}">
                    </div>
                    <div class="method" id="multibanco">
                        <img class="multibanco" src="/images/multibanco.png" alt="{{ __('messages.Multibanco') }}">
                    </div>
                    <div class="method" id="paypal">
                        <img class="paypal" src="/images/paypal.png" alt="{{ __('messages.PayPal') }}">
                    </div>
                </div>

                <!-- Hidden Input for Selected Payment Method -->
                <input type="hidden" name="payment_method" id="payment_method" value="">

                <!-- Billing Information -->
                <div class="title-line-container">
                    <span class="titleWithHr">{{ __('messages.Billing Information') }}</span>
                    <hr class="title-line-blue">
                </div>

                <div class="billing-info-container">
                    <!-- First Column -->
                    <div class="billing-column">
                        <label for="address">{{ __('messages.Billing address') }}</label>
                        <input type="text" name="address" id="address" placeholder="{{ __('messages.Enter your billing address') }}" value="{{ session('billingInfo.address', '') }}" required>

                        <label for="address2">{{ __('messages.Billing address, line 2') }}</label>
                        <input type="text" name="address2" id="address2" value="{{ session('billingInfo.address2', '') }}" placeholder="{{ __('messages.Additional address information') }}">

                        <label for="country">{{ __('messages.Country') }}</label>
                        <select name="country" id="country" required>
                            <option value="Portugal" {{ session('billingInfo.country') == 'Portugal' ? 'selected' : '' }}>
                                {{ __('messages.Portugal') }}
                            </option>
                            <option value="United Kingdom" {{ session('billingInfo.country') == 'United Kingdom' ? 'selected' : '' }}>
                                {{ __('messages.United Kingdom') }}
                            </option>
                        </select>
                        
                    </div>

                    <!-- Second Column -->
                    <div class="billing-column">
                        <label for="city">{{ __('messages.City') }}</label>
                        <input type="text" name="city" id="city" value="{{ session('billingInfo.city', '') }}" placeholder="{{ __('messages.Enter your city') }}" required>

                        <label for="zip">{{ __('messages.Zip or postal code') }}</label>
                        <input type="text" name="zip" id="zip" value="{{ session('billingInfo.zip', '') }}" placeholder="{{ __('messages.Enter your postal code') }}" required>
                    </div>
                </div>

                <!-- Awareness Checkbox -->
                <div class="awareCheckBox">
                    <label class="awareText">
                        <label class="switch">
                            <input type="checkbox" name="aware" id="aware" required>
                            <span class="slider"></span>
                        </label>
                        <span>{{ __('messages.I declare I am aware of this purchase') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <input type="hidden" id="paymentMethod" name="paymentMethod" value="">

                <button type="submit" class="button buttonContinue">{{ __('messages.Continue') }}</button>
            </form>
        </section>
    </div>

    <x-footer/>

    <script>
        function selectPaymentMethod(method) {
            document.getElementById('payment_method').value = method;
        }
    </script>
</body>
</html>