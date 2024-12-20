$(document).ready(function () {
    const popupHTML = `
	        <div id="popup-overlay"</div>
            <div id="popup">
            <img src="/images/trainTicket.jpg" class="train-image">
		<div class="flex-container">
			<div class="box1">
				<div class="details">
					<h1>São Bento → Aveiro</h1>
					<br>
					<span>&#x1F3AB;&#xFE0E;&nbsp;&nbsp<b>2</b></span>
					<br><br>
					<span>&#x1F552;&#xFE0E;&nbsp;&nbsp;<b>12:23 - 14:02</b></span>
				</div>
			</div>
			<div class="box2">
				<img class="qrCodeImage" src="/images/qrCode.png" alt="{{ __('messages.QR Code') }}">
			</div>
		</div>
 <div class="timetable-container">
                    <table class="timetable">
                        <thead>
                            <tr>
                                <th>{{ __('messages.Service') }}</th>
                                <th>{{ __('messages.Departure') }}</th>
                                <th>{{ __('messages.Line') }}</th>
                                <th>{{ __('messages.Carriage') }}</th>
                                <th>{{ __('messages.Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>R 1111</td>
                                <td>15:32</td>
                                <td>2</td>
                                <td>2</td>
                                <td>$ 2.20</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
        <button id="close-popup" class="close-button">{{ __('messages.Close') }}</button>
    </div>
    `;

    $('body').append(popupHTML);

    $('#show-popup').on('click', function () {
        $('#popup-overlay').fadeIn();
        $('#popup').fadeIn();
    });

    $('#close-popup').on('click', function () {
        $('#popup').fadeOut();
        $('#popup-overlay').fadeOut();
    });
});
