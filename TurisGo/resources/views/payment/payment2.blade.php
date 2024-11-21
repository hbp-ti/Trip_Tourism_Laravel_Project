<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/css/payment.css'])
</head>
<body>
   <x-header/>

    <main class="main-content">
        <section class="payment-section">
            <h1>Payment</h1>
            <div class="steps">
                <span class="step">1</span>
                <span class="step active">2</span>
                <span class="step">3</span>
            </div>
            <h2>Review</h2>

            <form class="payment-form">
                <div class="reviewInformation">
                    <div class="reviewInformationUpper">
                        <div class="info-title">Item Number</div>
                        <div class="info-value">12</div>
                        
                        <div class="info-title">Type</div>
                        <div class="info-value">Hotel and Tour</div>
                        
                        <div class="info-title">Total Price</div>
                        <div class="info-value">159€</div>
                    </div>
                    
                    <div class="reviewInformationLower">
                        <div class="info-title">Hotel Condado Castro - 2pax - 100€</div>
                        <div class="info-value">Lisboa Checkin - 12/01/2024 Checkout - 14/01/2024</div>
                        
                        <div class="info-title">Accommodation Type</div>
                        <div class="info-value">Executive Double Room</div>
                        
                        <div class="info-title">Full Day Tour in Coimbra - 1pax - 59€</div>
                        <div class="info-value">Coimbra Date - 05/03/2024 Language - Portuguese Duration - 8h</div>
                    </div>
                    
                    <div class="paymentMethod">
                        <img src="/images/multibanco.png" alt="Multibanco">
                        <div class="button buttonChange">Change</div>
                    </div>
                    
                    <div class="button buttonPay">Pay</div>
                </div>
            </form>
        </section>
    </main>

    <x-footer/>
</body>
</html>
