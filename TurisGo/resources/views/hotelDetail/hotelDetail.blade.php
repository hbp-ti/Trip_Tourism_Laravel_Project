<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- css e script de mapa interativo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
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
        <!-- Detalhes do hotel -->
        <span class="hotelTitle">{{ $hotelReservation->details->name }}
            <img width="130px" src="/images/rating.png">
        </span>
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
                <span><b>Checkin:</b> {{ \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkin)->format('d-m-Y') }}</span>
                <span><b>Checkout:</b> {{ \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkout)->format('d-m-Y') }}</span>
                <span><b>Reservation time:</b> {{ \Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkin)->diffInDays(\Carbon\Carbon::parse($hotelReservation->reservation_date_hotel_checkout)) }}</span>
            </div>
        </div>

        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Direction') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
            <button id="toggleFilters" class="btn btn-secondary">{{ __('messages.Show Filters') }}</button>
        </div>

        <!-- Mapa Interativo -->
        <div class="map-section">
            <div id="hotel-map" style="height: 400px;"></div>
        </div>

        <button class="btn btn-secondary">{{ __('messages.Download') }}</button>
        <button id="detailsBtn" class="btn btn-secondary">{{ __('messages.Details') }}</button> <!-- Novo botão -->
    </div>

    <!-- Painel de Informações no canto superior direito -->
    <div id="mapInfoPanel" style="position: absolute; top: 950px; right: 480px; z-index: 1000; background-color: rgba(255, 255, 255, 0.7); padding: 10px; border-radius: 10px; display: flex; align-items: center; flex-direction: column;">
        <div id="timeInfo" style="display: flex; align-items: center; margin-bottom: 10px;">
            <img src="/images/tempo.png" alt="Tempo" style="width: 24px; height: 24px; margin-right: 17px;">
            <span id="timeText"></span> <!-- Valor de tempo que pode ser dinâmico -->
        </div>
        <div id="distanceInfo" style="display: flex; align-items: center;">
            <img src="/images/distancia.png" alt="Distância" style="width: 24px; height: 24px; margin-right: 8px;">
            <span id="distanceText"></span> <!-- Valor de distância que pode ser dinâmico -->
        </div>
    </div>

    @if (session('popup'))
    {!! session('popup') !!}
    @endif
    <x-footer />

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Coletando as coordenadas do hotel passadas pelo PHP
            const latHotel = {{ $hotelReservation->details->lat }};
            const lonHotel = {{ $hotelReservation->details->lon }};
            const timeText = document.getElementById('timeText');
            const distanceText = document.getElementById('distanceText');

            // Inicializando o mapa
            const map = L.map('hotel-map').setView([latHotel, lonHotel], 13); // Definir o centro e o nível de zoom

            // Adicionar camada do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Adicionar marcador para o hotel
            const hotelMarker = L.marker([latHotel, lonHotel]).addTo(map)
                .bindPopup('<b>{{ $hotelReservation->details->name }}</b><br>{{ $hotelReservation->details->description }}')
                .openPopup();

            // Criar ícone personalizado para o marcador da localização do usuário
            const userIcon = L.icon({
                iconUrl: "/images/seta.png",  // Substitua pelo caminho para o seu ícone
                iconSize: [30, 30],  // Tamanho do ícone
                iconAnchor: [15, 30],  // Onde o ícone será ancorado no ponto de coordenadas
                popupAnchor: [0, -30]  // Onde o popup será ancorado em relação ao ícone
            });

            // Inicializar a variável para as direções
            let routeControl;

            // Obter a localização do usuário e traçar a rota
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const latUser = position.coords.latitude;
                    const lonUser = position.coords.longitude;

                    // Adicionar marcador para a localização do usuário
                    const userMarker = L.marker([latUser, lonUser], { icon: userIcon }).addTo(map)
                        .bindPopup('Sua localização')
                        .openPopup()
                        .setZIndexOffset(1000);  // Ajustar a sobreposição para garantir que o marcador fique em cima do mapa

                    // Traçar a rota do usuário até o hotel sem exibir painel de direções
                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(latUser, lonUser),
                            L.latLng(latHotel, lonHotel)
                        ],
                        createMarker: function() { return null; },  // Não criar marcadores intermediários
                        routeWhileDragging: true,
                        showAlternatives: false,
                        lineOptions: { styles: [{ color: '#FFF100', weight: 4 }] },  // Estilo da linha da rota
                        summaryDisplay: false,  // Não exibe o painel de direções
                        collapsible: false,  // Desabilita a funcionalidade de painel expansível
                    }).addTo(map);

                    // Quando a rota for calculada, captura tempo e distância
                    routeControl.on('routesfound', function(event) {
                        const route = event.routes[0];  // Pega a primeira rota
                        const distance = route.summary.totalDistance / 1000;  // Distância em km
                        const time = route.summary.totalTime / 60;  // Tempo em minutos

                        // Atualiza o painel com os valores de tempo e distância
                        distanceText.textContent = `${distance.toFixed(1)} km`;
                        timeText.textContent = `${Math.floor(time)} min`; // Exibe apenas minutos

                    });
                }, function() {
                    alert("Geolocalização falhou ou foi negada.");
                });
            } else {
                alert("Geolocalização não é suportada neste navegador.");
            }

            // Funcionalidade para mostrar e ocultar o painel de detalhes
            document.getElementById("detailsBtn").addEventListener("click", function() {
                const routingContainer = document.querySelector('.leaflet-routing-container');
                if (routingContainer) {
                    // Alterna a exibição da div
                    routingContainer.style.display = (routingContainer.style.display === 'none' || routingContainer.style.display === '') ? 'block' : 'none';
                }
            });
        });
    </script>
</body>

</html>
