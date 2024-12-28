<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <!-- CSS e script de mapa interativo (Leaflet) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    @vite(['resources/css/tourDetail.css', 'resources/js/tourDetail.js', 'resources/js/mapa.js'])
</head>

<body>
    <x-header />

    <!-- Hero Section -->
    <div class="header">
        <h1>{{ __('messages.Tour Details') }}</h1>
        <p>{{ __('messages.Some details about your reservation') }}</p>
    </div>

    <!-- Tour Content Section -->
    <div class="tour-details">
        <h2>{{ $tourReservation->details->name }}</h2>
        <p class="tour-details-text">
            {{ $tourReservation->details->description }}
        </p>

        <!-- Image Slider -->
        <div class="image-slider">
            <img src="{{ $tourReservation->details->item->images[0]->url }}" alt="{{ __('messages.Parque Jump') }}">
        </div>

        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Direction') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
            <button id="toggleFilters" class="btn btn-secondary">Show Filters</button>
        </div>

        <!-- Container que agrupa o Mapa e as Opções -->
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

                <!-- Caixa de Informação do Comboio -->
                <div id="trainInfo" class="train-info hidden train-box">
                    <p><strong>São Bento → Aveiro</strong></p>
                    <p>
                        <img src="{{ asset('images/locmapa.png') }}" alt="Location Icon" style="width: 12px; vertical-align: middle;">
                        <span class="small-text">Rua São Mamede nº291 1312-123</span>
                    </p>
                    <p>
                        <img src="{{ asset('images/horamapa.png') }}" alt="Clock" style="width: 16px; margin-right: 5px;">
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

            <!-- Mapa Interativo (Leaflet) -->
            <div class="map-section" style="position: relative;">
                <div id="tour-map" style="height: 400px; position: relative;">
                    <!-- Painel de Informações dentro do mapa, canto superior direito -->
                    <div id="mapInfoPanel" style="
                        position: absolute;
                        top: 10px; 
                        right: 10px;
                        z-index: 1000;
                        background-color: rgba(255, 255, 255, 0.7);
                        padding: 10px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        flex-direction: column;
                    ">
                        <div id="timeInfo" style="display: flex; align-items: center; margin-bottom: 10px;">
                            <img src="/images/tempo.png" alt="Tempo" style="width: 24px; height: 24px; margin-right: 10px;">
                            <span id="timeText"></span>
                        </div>
                        <div id="distanceInfo" style="display: flex; align-items: center;">
                            <img src="/images/distancia.png" alt="Distância" style="width: 24px; height: 24px; margin-right: 8px;">
                            <span id="distanceText"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-secondary">{{ __('messages.Download') }}</button>
        <!-- Botão para exibir/ocultar painel de rotas -->
        <button id="detailsBtn" class="btn btn-secondary">{{ __('messages.Details') }}</button>

        <br><br>

        <!-- Weather Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Weather') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
        </div>
        <div class="weather-section">
            <div class="weather-card-today">
                <div class="weather-head-today">
                    <h5>{{ __('Monday') }}</h5>
                    <h6>{{ __('6 Oct') }}</h6>
                </div>
                <div class="weather-content">
                    <h2>Lisboa</h2>
                    <div class="temp-today">
                        <h1 class="temp">23ºC</h1>
                        <img src="{{ asset('images/weatherPartlyCloudy.png') }}" alt="Partly Cloudy">
                    </div>
                    <div class="weather-status">
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconRain.png') }}" alt="Rain">
                            <h6>20%</h6>
                        </div>
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconWind.png') }}" alt="Wind">
                            <h6>18km/h</h6>
                        </div>
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconWindDirection.png') }}" alt="Wind Direction">
                            <h6>East</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Tuesday') }}</h5>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherRaining.png') }}" alt="Raining">
                    <h3>23ºC</h3>
                    <h6>68%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Wednesday') }}</h5>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherLightning.png') }}" alt="Lightning">
                    <h3>18ºC</h3>
                    <h6>26%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Thursday') }}</h5>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherWind.png') }}" alt="Wind">
                    <h3>17ºC</h3>
                    <h6>10%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Friday') }}</h5>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherPartlyCloudy.png') }}" alt="Partly Cloudy">
                    <h3>23ºC</h3>
                    <h6>17%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Saturday') }}</h5>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherLightning.png') }}" alt="Lightning">
                    <h3>20ºC</h3>
                    <h6>45%</h6>
                </div>
            </div>
            <div class="weather-card">
                <div class="weather-head">
                    <h5>{{ __('Sunday') }}</h5>
                </div>
                <div class="weather-content">
                    <img src="{{ asset('images/weatherRaining.png') }}" alt="Raining">
                    <h3>12ºC</h3>
                    <h6>89%</h6>
                </div>
            </div>
        </div>

        <!-- Train/Bus Tickets Section -->
        @if (session('popup'))
            {!! session('popup') !!}
        @endif
    </div>

    <x-footer />

    <!-- Script para inicializar e controlar o mapa Leaflet -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Coletando as coordenadas do tour via PHP
            const latTour = {{ $tourReservation->details->lat }};
            const lonTour = {{ $tourReservation->details->lon }};
            const timeText = document.getElementById('timeText');
            const distanceText = document.getElementById('distanceText');

            // Inicializando o mapa
            const map = L.map('tour-map').setView([latTour, lonTour], 13); // Centro e zoom

            // Adicionar camada do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Adicionar marcador para o local do Tour
            const tourMarker = L.marker([latTour, lonTour]).addTo(map)
                .bindPopup('<b>{{ $tourReservation->details->name }}</b><br>{{ $tourReservation->details->description }}')
                .openPopup();

            // Ícone personalizado para a localização do usuário
            const userIcon = L.icon({
                iconUrl: "/images/seta.png", // Ajuste para o seu caminho de ícone
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            // Variável para as direções (rota)
            let routeControl;

            // Obter geolocalização do usuário e traçar a rota
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const latUser = position.coords.latitude;
                    const lonUser = position.coords.longitude;

                    // Marcador para a localização do usuário
                    const userMarker = L.marker([latUser, lonUser], { icon: userIcon })
                        .addTo(map)
                        .bindPopup('Sua localização')
                        .openPopup()
                        .setZIndexOffset(1000);

                    // Rota do usuário até o Tour sem exibir painel de direções
                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(latUser, lonUser),
                            L.latLng(latTour, lonTour)
                        ],
                        createMarker: function () { return null; }, // Sem marcadores intermediários
                        routeWhileDragging: true,
                        showAlternatives: false,
                        lineOptions: { styles: [{ color: '#FFF100', weight: 4 }] },
                        summaryDisplay: false,
                        collapsible: false,
                    }).addTo(map);

                    // Quando a rota for calculada, capturar tempo e distância
                    routeControl.on('routesfound', function (event) {
                        const route = event.routes[0]; // Primeira rota
                        const distance = route.summary.totalDistance / 1000; // Em km
                        const time = route.summary.totalTime / 60; // Em minutos

                        distanceText.textContent = `${distance.toFixed(1)} km`;
                        timeText.textContent = `${Math.ceil(time)} min`;

                    });
                }, function () {
                    alert("Geolocalização falhou ou foi negada.");
                });
            } else {
                alert("Geolocalização não é suportada neste navegador.");
            }

            // Botão que mostra/oculta o painel de detalhes (rotas)
            document.getElementById("detailsBtn").addEventListener("click", function() {
                const routingContainer = document.querySelector('.leaflet-routing-container');
                if (routingContainer) {
                    routingContainer.style.display =
                        (routingContainer.style.display === 'none' || routingContainer.style.display === '')
                        ? 'block'
                        : 'none';
                }
            });
        });
    </script>
</body>
</html>
