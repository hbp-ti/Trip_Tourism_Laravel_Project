<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- css e script  de mapa interativo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/js/jquery-3.7.1.min.js', 'resources/css/hotelDetail.css', 'resources/js/hotelDetail.js', 'resources/js/mapa.js', 'resources/js/popupTrainTicket.js', 'resources/css/popupTrainTicket.css'])
</head>

<body>
    <x-header />
    <!-- Hero Section -->
    <div class="header">
        <h1>{{ __('messages.Hotel Details') }}</h1>
        <p>{{ __('messages.Some details about your reservation') }}</p>
    </div>
    <!-- Tour Content Section -->
    <div class="tour-details">
        <span class="hotelTitle">{{ $hotelReservation->details->name }}
          <!--$hotelReservation->details->average_guest_rating-->
          <img width="130px"
                src="/images/rating.png"></span>
        <p class="tour-details-text">
            {{ $hotelReservation->details->description }}
        </p>
        <!-- Image Slider -->
        <div class="roomDetails">
            <div class="roomDetailsImage">
                <img src="{{ $hotelReservation->details->item->images[0]->url }}" alt="Quarto">
            </div>
            <div class="roomDetailsText">
                <span><b>Room type:</b> {{ $hotelReservation->room_type_hotel }}</span>

                @php
                    $checkin = \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkin);
                    $checkout = \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkout);

                    $checkinFormated = \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkin)->format(
                        'd-m-Y',
                    );
                    $checkoutFormated = \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkout)->format(
                        'd-m-Y',
                    );

                    $daysReserved = $checkin->diffInDays($checkout); // Calcula a diferença em dias
                @endphp
                <span><b>Checkin:</b> {{ $checkinFormated }}</span>
                <span><b>Checkout:</b> {{ $checkoutFormated }}</span>
                <span><b>Reservation time:</b> {{ $daysReserved }}</span>
                <span><b>Bed Count:</b> {{ $hotelReservation->details->rooms[0]->bed_count }}</span>
                <span><b>Bed Type:</b> {{ $hotelReservation->details->rooms[0]->bed_type }}</span>
            </div>
        </div>

        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Direction') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
            <button id="toggleFilters" class="btn btn-secondary">{{ __('messages.Show Filters') }}</button>
        </div>
        <!-- Mapa Interativo -->
        <div class="popup-container">
            <!-- Opções de transporte e adicionais -->
            <div id="filtersContainer" class="options-section hidden">
                <!-- Transportes com linha azul -->
                <div class="transport-title">
                    <h4>{{ __('messages.Transport') }}</h4>
                    <div class="line blue-line"></div>
                </div>
                <div class="buttons">
                    <button id="carButton" class="transport-button">
                        <img src="{{ asset('images/popupmapacarro.png') }}" alt="Car">
                    </button>
                    <button id="trainButton" class="transport-button">
                        <img src="{{ asset('images/popupmapacomboio.png') }}" alt="Train">
                    </button>
                    <button id="walkButton" class="transport-button">
                        <img src="{{ asset('images/popupmapape.png') }}" alt="Walk">
                    </button>
                </div>
                <!-- Options com linha à frente -->
                <div class="options-title">
                    <h4>{{ __('messages.Options') }}</h4>
                    <div class="line orange-line"></div>
                </div>
                <!-- Caixa de Informação do Comboio (Adicionar Aqui!) -->
                <div id="trainInfo" class="train-info hidden train-box">
                    <p>
                        <strong>São Bento → Aveiro</strong>
                    </p>
                    <p>
                        <img src="{{ asset('images/locmapa.png') }}" alt="Location Icon"
                            style="width: 12px; vertical-align: middle;">
                        <span class="small-text">Rua São Mamede nº291 1312-123</span>
                    </p>
                    <p>
                        <img src="{{ asset('images/horamapa.png') }}" alt="Clock"
                            style="width: 16px; margin-right: 5px;">
                        <span class="hora-text">12:23 - 14:02</span>
                    </p>
                </div>
                <!-- Options Section -->
                <div id="optionsContainer" class="options">
                    <div class="toggle-switch">
                        <label for="tolls">{{ __('messages.Tolls') }}</label>
                        <label class="toggle">
                            <input type="checkbox" id="tolls" class="toggle-option">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="toggle-switch">
                        <label for="radars">{{ __('messages.Radars') }}</label>
                        <label class="toggle">
                            <input type="checkbox" id="radars" class="toggle-option">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="toggle-switch">
                        <label for="urbanAreas">{{ __('messages.Urban areas') }}</label>
                        <label class="toggle">
                            <input type="checkbox" id="urbanAreas" class="toggle-option">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="toggle-switch">
                        <label for="customs">{{ __('messages.Customs') }}</label>
                        <label class="toggle">
                            <input type="checkbox" id="customs" class="toggle-option">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="toggle-switch">
                        <label for="motorway">{{ __('messages.Motorway') }}</label>
                        <label class="toggle">
                            <input type="checkbox" id="motorway" class="toggle-option">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- Mapa -->
            <div class="map-section">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31255.612595920426!2d-8.4463744!3d40.574588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22ebf03068b2b3%3A0x833c2e505b1b476c!2s%C3%81gueda%2C%20Portugal!5e0!3m2!1sen!2spt!4v1696420912345!5m2!1sen!2spt"
                    width="100%" height="100%" style="border: none;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <button class="btn btn-secondary">{{ __('messages.Download') }}</button>
    </div>
    @if (session('popup'))
    {!! session('popup') !!}
@endif
    <x-footer />
</body>

</html>
