<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/payment.css'])
</head>
<body>
   <x-header/>

	<h1 class="title">Payment</h1>

    <div class="main-content">
        <section class="payment-section">
            
            <div class="steps">
                <span class="step">1</span>
                <span class="step active">2</span>
                <span class="step">3</span>
            </div>
			
            <span class="subtitle">Review</span>

            <form class="payment-form">
                <div class="reviewInformation">
                    <div class="reviewInformationUpper">
						<div class="itemNumber">
							<div class="info-title">Item Number</div>
							<div class="info-value">12</div>
						</div>
						<div class="type">
							<div class="info-title">Type</div>
							<div class="info-value">Hotel and Tour</div>
						</div>
						<div class="totalPrice">
							<div class="info-title">Total Price</div>
							<div class="info-value">159€</div>
						</div>
						<div class="iconPurchaseClass">
							<img src="/images/iconPurchase.png">
						</div>
                    </div>
                    
                    <div class="reviewInformationLower">
                        <div class="info-title">Hotel Condado Castro - 2pax - 100€</div>
						<hr>
                        <div class="info-value">Lisboa&emsp;&emsp;&emsp;Checkin - 12/01/2024&emsp;&emsp;&emsp;Checkout - 14/01/2024
                        <br>
                        
						Accommodation Type - Executive Double Room</div>
                        <br>
						
                        <div class="info-title">Full Day Tour in Coimbra - 1pax - 59€</div>
						<hr>
                        <div class="info-value">Coimbra Date - 05/03/2024&emsp;&emsp;&emsp;Language - Portuguese&emsp;&emsp;&emsp;Duration - 8h</div>
                    </div>
                    
                    <div class="paymentMethod">
                        <img src="/images/multibanco.png" alt="Multibanco">
                        <a href="{{ route('payment1') }}" class="button buttonChange">Change</a>
                    </div>

                    <a href="{{ route('payment3') }}" class="button buttonPay">Pay</a>
                </div>
            </form>
        </section>
    </div>

    <x-footer/>
</body>
</html>
