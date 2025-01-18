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
    @vite(['resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/css/hotelDetail.css', 'resources/js/hotelDetail.js', 'resources/js/mapa.js', 'resources/js/popupTrainTicket.js', 'resources/css/popupTrainTicket.css'])
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

                <!--
                  Caixa de Informação do Comboio: vamos preencher dinamicamente
                  com as informações da estação e os comboios disponíveis
                -->
                <div id="trainInfo" class="train-info hidden train-box" style="padding: 10px;">
                    <!-- Conteúdo padrão (podes remover se quiseres) -->
                    <p><strong>Estação / Comboios</strong></p>
                    <div id="trainDetails"></div>
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
                <div id="hotel-map" style="height: 510px; position: relative;">
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

                <!--
                  Caixa de Informação do Comboio: vamos preencher dinamicamente
                  com as informações da estação e os comboios disponíveis
                -->
                <div id="trainInfo" class="train-info hidden train-box" style="padding: 10px;">
                    <!-- Conteúdo padrão (podes remover se quiseres) -->
                    <p><strong>Estação / Comboios</strong></p>
                    <div id="trainDetails"></div>
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


        </div>

        <button class="btn btn-secondary">{{ __('messages.Download') }}</button>
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

    <script>
	const appUrl = "{{ config('app.url') }}";

    document.addEventListener("DOMContentLoaded", function () {
        const latHotel = {{ $hotelReservation->details->lat }};
        const lonHotel = {{ $hotelReservation->details->lon }};
        const timeText = document.getElementById('timeText');
        const distanceText = document.getElementById('distanceText');
        let latUser, lonUser;  // Declarando globalmente as variáveis para latitude e longitude do usuário

        // Inicializando o mapa
        const map = L.map('hotel-map').setView([latHotel, lonHotel], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const hotelMarker = L.marker([latHotel, lonHotel]).addTo(map)
            .bindPopup('<b>{{ $hotelReservation->details->name }}</b><br>{{ $hotelReservation->details->description }}')
            .openPopup();

        const userIcon = L.icon({
            iconUrl: "/images/seta.png",
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
        });

        let routeControl;

        // Obter a localização do usuário e traçar a rota
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                latUser = position.coords.latitude;  // Agora 'latUser' é definido aqui
                lonUser = position.coords.longitude;  // Agora 'lonUser' é definido aqui

                const userMarker = L.marker([latUser, lonUser], { icon: userIcon }).addTo(map)
                    .bindPopup('Sua localização')
                    .openPopup()
                    .setZIndexOffset(1000);  // Ajuste a sobreposição para garantir que o marcador fique em cima do mapa

                routeControl = L.Routing.control({
                    waypoints: [
                        L.latLng(latUser, lonUser),
                        L.latLng(latHotel, lonHotel)
                    ],
                    createMarker: function() { return null; },
                    routeWhileDragging: true,
                    showAlternatives: false,
                    lineOptions: { styles: [{ color: '#FFF100', weight: 4 }] },
                    summaryDisplay: false,
                    collapsible: false,
                }).addTo(map);

                routeControl.on('routesfound', function(event) {
                    const route = event.routes[0];
                    const distance = route.summary.totalDistance / 1000;
                    const time = route.summary.totalTime / 60;

                    distanceText.textContent = `${distance.toFixed(1)} km`;
                    timeText.textContent = `${Math.floor(time)} min`;
                });
            }, function() {
                alert("Geolocalização falhou ou foi negada.");
            });
        }

        // ============================ BOTÃO COMBOIO ============================
        document.getElementById('trainButton').addEventListener('click', () => {
            // Agora latUser e lonUser estão definidos fora da geolocalização e são acessíveis aqui
            const overpassUrl = `https://overpass-api.de/api/interpreter?data=[out:json];node["railway"="station"](around:20000,${latUser},${lonUser});out;`;

            fetch(overpassUrl)
                .then(response => response.json())
                .then(data => {
                    if (!data.elements || data.elements.length === 0) {
                        alert("Não foi encontrada nenhuma estação de comboio num raio de 20km.");
                        return;
                    }

                    let nearestStation = null;
                    let minDist = Infinity;

                    data.elements.forEach(station => {
                        const dist = haversineDist(latUser, lonUser, station.lat, station.lon);
                        if (dist < minDist) {
                            minDist = dist;
                            nearestStation = station;
                        }
                    });

                    if (!nearestStation) {
                        alert("Nenhuma estação encontrada.");
                        return;
                    }

                    const stationName = nearestStation.tags.name || "Estação sem nome";
                    const stationMarker = L.marker([nearestStation.lat, nearestStation.lon]).addTo(map)
                        .bindPopup(`<b>${stationName}</b><br>Distância: ${(minDist / 1000).toFixed(2)} km`)
                        .openPopup();

                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(latUser, lonUser),
                            L.latLng(nearestStation.lat, nearestStation.lon)
                        ],
                        createMarker: function() { return null; },
                        routeWhileDragging: false,
                        showAlternatives: false,
                        lineOptions: { styles: [{ color: '#00c0ff', weight: 4 }] },
                        summaryDisplay: false,
                        collapsible: false,
                    }).addTo(map);

                    document.getElementById('trainInfo').classList.remove('hidden');
                    fetch(`/train/station?nome=${encodeURIComponent(stationName)}`)
                        .then(r => r.json())
                        .then(stationData => {
                            const trainDetailsDiv = document.getElementById('trainDetails');
                            if (stationData.error) {
                                trainDetailsDiv.innerHTML = `<p style="color:red;">${stationData.error}</p>`;
                                return;
                            }

                            let html = `<h4>${stationName}</h4>`;
                            if (stationData.trains && stationData.trains.length > 0) {
                                html += `<ul>`;
                                stationData.trains.forEach(t => {
                                    html += `<li>Comboio: ${t.id} — Horário: ${t.time}</li>`;
                                });
                                html += `</ul>`;
                            } else {
                                html += `<p>Não há dados de comboios disponíveis.</p>`;
                            }

                            trainDetailsDiv.innerHTML = html;
                        })
                        .catch(err => {
                            console.error('Erro ao buscar dados da API interna:', err);
                            document.getElementById('trainDetails').innerHTML = `<p style="color:red;">Falha ao obter detalhes da estação.</p>`;
                        });
                })
                .catch(err => {
                    console.error(err);
                    alert("Erro ao obter dados do Overpass API.");
                });
        });

        function haversineDist(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Raio médio da Terra em metros
            const toRad = x => x * Math.PI / 180;
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);
            const lat1Rad = toRad(lat1);
            const lat2Rad = toRad(lat2);

            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.sin(dLon / 2) * Math.sin(dLon / 2) *
                      Math.cos(lat1Rad) * Math.cos(lat2Rad);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // distância em metros
        }
    });
    </script>
</body>

</html>
