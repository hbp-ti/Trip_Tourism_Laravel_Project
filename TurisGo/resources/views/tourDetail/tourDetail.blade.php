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

    @vite(['resources/css/tourDetail.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/tourDetail.js', 'resources/js/mapa.js'])
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
            <button id="toggleFilters" class="btn btn-filters">Show Filters</button>
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
                <div id="tour-map" style="height: 500px; position: relative;">
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
                            <img src="/images/tempo.png" alt="Tempo"
                                style="width: 24px; height: 24px; margin-right: 10px;">
                            <span id="timeText"></span>
                        </div>
                        <div id="distanceInfo" style="display: flex; align-items: center;">
                            <img src="/images/distancia.png" alt="Distância"
                                style="width: 24px; height: 24px; margin-right: 8px;">
                            <span id="distanceText"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-download">{{ __('messages.Download') }}</button>
        <br><br>

        <!-- Weather Section -->
        <div class="section-title-container">
            <h3 class="section-title">{{ __('messages.Weather') }}</h3>
            <hr class="section-divider" style="background-color: #C76A37;">
        </div>
        <div class="weather-section">
            <div class="weather-card-today">
                <div class="weather-head-today">
                    <h5 id="valueWeekday">{{ __('Monday') }}</h5>
                    <h6 id="valueDate">{{ __('6 Oct') }}</h6>
                </div>
                <div class="weather-content">
                    <h2 id="valueLocation">Lisboa</h2>
                    <div class="temp-today">
                        <h1 id="valueTemp" class="temp">23ºC</h1>
                        <img id="imgWeatherToday" src="{{ asset('images/weatherPartlyCloudy.png') }}"
                            alt="Partly Cloudy">
                    </div>
                    <div class="weather-status">
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconRain.png') }}" alt="Rain">
                            <h6 id="valueHumidity">20%</h6>
                        </div>
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconWind.png') }}" alt="Wind">
                            <h6 id="valueWind">18 km/h</h6>
                        </div>
                        <div class="weather-individual-status">
                            <img src="{{ asset('images/weatherIconWindDirection.png') }}" alt="Wind Direction">
                            <h6 id="valueWindDirection">East</h6>
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
        // Função de distância (Haversine) para encontrar estação mais próxima
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

        document.addEventListener("DOMContentLoaded", function () {
            const weatherApiKey = "fd9f06cd709e44db99c183433250301";

            const latTour = {{ $tourReservation->details->lat }};
            const lonTour = {{ $tourReservation->details->lon }};

            function formatDate(dataString, locale, options) {
                const data = new Date(dataString);

                const formatador = new Intl.DateTimeFormat(locale, options);
                return formatador.format(data);
            }
            //const dataOriginal = "2025-01-03 17:59";
            //const dataFormatada = formatDate(dataOriginal);
            //console.log(dataFormatada); // Saída: "3 jan"

            function replaceText(obj) {
                //console.log(obj["current"]["temp_c"]);

                let location, humidity, windDir, temp, wind, date, weekday, imgURL;

                location = obj["location"]["name"];

                humidity = obj["current"]["humidity"] + "%";

                windDir = obj["current"]["wind_dir"];

                if (obj["current"]["temp_c"] % 1 !== 0) {
                    temp = obj["current"]["temp_c"].toString().split('.')[0] + "ºC";
                }

                else {
                    temp = obj["current"]["temp_c"] + "ºC";
                }

                if (obj["current"]["wind_kph"] % 1 !== 0) {
                    wind = obj["current"]["wind_kph"].toString().split('.')[0] + " km/h";
                }

                else {
                    wind = obj["current"]["wind_kph"] + " km/h";
                }

                date = formatDate(obj["location"]["localtime"], 'pt-PT', { day: 'numeric', month: 'long' });

                weekday = formatDate(obj["location"]["localtime"], 'pt-PT', { weekday: "long" });

                imgURL = "https:" + obj["current"]["condition"]["icon"];

                $("#valueLocation").text(location);
                $("#valueHumidity").text(humidity);
                $("#valueWindDirection").text(windDir);
                $("#valueTemp").text(temp);
                $("#valueWind").text(wind);
                $("#valueDate").text(date);
                $("#valueWeekday").text(weekday);
                $("#imgWeatherToday").attr('src', imgURL);
            }

            function getWeather() {
                const xmlhttprequestWeather = new XMLHttpRequest();
                xmlhttprequestWeather.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const weatherObj = JSON.parse(this.response);
                        //console.log(weatherObj);
                        //console.log("vento: " + weatherObj["current"]["cloud"]);
                        replaceText(weatherObj);
                    }
                };
                xmlhttprequestWeather.open("GET", "http://api.weatherapi.com/v1/current.json?key=" + weatherApiKey + "&q=" + latTour + "," + lonTour, true);
                xmlhttprequestWeather.send();
            }

            getWeather();

            const timeText = document.getElementById('timeText');
            const distanceText = document.getElementById('distanceText');
            let map;
            let routeControl; // Para as rotas (carro, pé, etc.)

            // Inicializar mapa
            map = L.map('tour-map').setView([latTour, lonTour], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marcador do Tour
            const tourMarker = L.marker([latTour, lonTour]).addTo(map)
                .bindPopup('<b>{{ $tourReservation->details->name }}</b><br>{{ $tourReservation->details->description }}')
                .openPopup();

            // Ícone para a localização do usuário
            const userIcon = L.icon({
                iconUrl: "/images/seta.png",
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            // Obter geolocalização do usuário
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const latUser = position.coords.latitude;
                    const lonUser = position.coords.longitude;

                    // Marcador da posição do usuário
                    L.marker([latUser, lonUser], { icon: userIcon })
                        .addTo(map)
                        .bindPopup('Sua localização')
                        .openPopup()
                        .setZIndexOffset(1000);

                    // Função para criar rota de acordo com o perfil (carro, pé, etc.)
                    function createRoute(profile) {
                        // Se já existir rota, remove do mapa
                        if (routeControl) {
                            map.removeControl(routeControl);
                        }

                        routeControl = L.Routing.control({
                            waypoints: [
                                L.latLng(latUser, lonUser),
                                L.latLng(latTour, lonTour)
                            ],
                            createMarker: function () { return null; },
                            routeWhileDragging: true,
                            showAlternatives: false,
                            lineOptions: { styles: [{ color: '#FFF100', weight: 4 }] },
                            summaryDisplay: false,
                            collapsible: false,
                            router: L.Routing.osrmv1({
                                serviceUrl: 'https://router.project-osrm.org/route/v1',
                                profile: profile
                            })
                        }).addTo(map);

                        // Quando a rota for calculada, atualizar distância e tempo
                        routeControl.on('routesfound', function (event) {
                            const route = event.routes[0];
                            const distance = route.summary.totalDistance / 1000;
                            const time = route.summary.totalTime / 60;

                            distanceText.textContent = `${distance.toFixed(1)} km`;
                            timeText.textContent = `${Math.ceil(time)} min`;
                        });
                    }

                    // Rota inicial (carro)
                    createRoute('driving');

                    // Botão carro
                    document.getElementById('carButton').addEventListener('click', () => {
                        createRoute('driving');
                    });

                    // Botão pé
                    document.getElementById('walkButton').addEventListener('click', () => {
                        createRoute('foot');
                    });

                    // ============================
                    //  BOTÃO COMBOIO (TRAIN)
                    // ============================
                    document.getElementById('trainButton').addEventListener('click', () => {
                        // Vamos buscar estações numa área de 20km usando Overpass
                        const overpassUrl = `https://overpass-api.de/api/interpreter?data=[out:json];node["railway"="station"](around:20000,${latUser},${lonUser});out;`;

                        fetch(overpassUrl)
                            .then(response => response.json())
                            .then(data => {
                                if (!data.elements || data.elements.length === 0) {
                                    alert("Não foi encontrada nenhuma estação de comboio num raio de 20km.");
                                    return;
                                }

                                // Encontrar a estação mais próxima do utilizador
                                let nearestStation = null;
                                let minDist = Infinity;

                                data.elements.forEach(station => {
                                    const dist = haversineDist(
                                        latUser, lonUser,
                                        station.lat, station.lon
                                    );
                                    if (dist < minDist) {
                                        minDist = dist;
                                        nearestStation = station;
                                    }
                                });

                                if (!nearestStation) {
                                    alert("Nenhuma estação encontrada.");
                                    return;
                                }

                                // Colocar um marcador na estação mais próxima
                                const stationName = nearestStation.tags.name || "Estação sem nome";
                                const stationMarker = L.marker([nearestStation.lat, nearestStation.lon]).addTo(map)
                                    .bindPopup(`<b>${stationName}</b><br>Distância: ${(minDist / 1000).toFixed(2)} km`)
                                    .openPopup();

                                // Criar rota do utilizador até a estação
                                if (routeControl) {
                                    map.removeControl(routeControl);
                                }
                                routeControl = L.Routing.control({
                                    waypoints: [
                                        L.latLng(latUser, lonUser),
                                        L.latLng(nearestStation.lat, nearestStation.lon)
                                    ],
                                    createMarker: function () { return null; },
                                    routeWhileDragging: false,
                                    showAlternatives: false,
                                    lineOptions: { styles: [{ color: '#00c0ff', weight: 4 }] },
                                    summaryDisplay: false,
                                    collapsible: false,
                                    router: L.Routing.osrmv1({
                                        serviceUrl: 'https://router.project-osrm.org/route/v1',
                                        // podes usar 'foot' se o deslocamento for a pé
                                        profile: 'driving'
                                    })
                                }).addTo(map);

                                // Exibe a div com informações do comboio
                                const trainInfoDiv = document.getElementById('trainInfo');
                                trainInfoDiv.classList.remove('hidden');

                                // Exemplo de chamada para tua API de comboios:
                                fetch('/train/station?nome=' + encodeURIComponent(stationName))
                                    .then(r => r.json())
                                    .then(stationData => {
                                        const trainDetailsDiv = document.getElementById('trainDetails');

                                        if (stationData.error) {
                                            trainDetailsDiv.innerHTML = `<p style="color:red;">${stationData.error}</p>`;
                                            return;
                                        }

                                        // Exemplo simples de HTML. Ajuste conforme a estrutura real do stationData
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
                                        document.getElementById('trainDetails').innerHTML =
                                            `<p style="color:red;">Falha ao obter detalhes da estação.</p>`;
                                    });
                            })
                            .catch(err => {
                                console.error(err);
                                alert("Erro ao obter dados do Overpass API.");
                            });
                    });
                    // ============================
                    // FIM DO BOTÃO COMBOIO
                    // ============================

                }, function () {
                    alert("Geolocalização falhou ou foi negada.");
                });
            } else {
                alert("Geolocalização não é suportada neste navegador.");
            }
        });
    </script>
</body>

</html>