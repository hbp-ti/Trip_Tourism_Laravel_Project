// Inicializar o mapa
const map = L.map('map').setView([40.641, -8.653], 13); // Coordenadas iniciais (Aveiro)

const hotelIcon = L.icon({
    iconUrl: '/images/hotelMarkerMap.png',
    iconSize: [41, 41], // Tamanho do ícone
    iconAnchor: [12, 41], // Posição do ponto de ancoragem
    popupAnchor: [1, -34] // Posição do popup
});

const tourIcon = L.icon({
    iconUrl: '/images/tourMarkerMap.png',
    iconSize: [41, 41], // Tamanho do ícone
    iconAnchor: [12, 41], // Posição do ponto de ancoragem
    popupAnchor: [1, -34] // Posição do popup
});

// Camada clara
const lightLayer = L.tileLayer('https://tile.jawg.io/jawg-streets/{z}/{x}/{y}{r}.png?access-token=Fr35xfUxIv64aS7qhlbFS5QxTHFFMHLFzVTYxA4UsZGE3Dr3Gi7ccrJbtfIQaOnK', {
    attribution: '© JawgMaps, OpenStreetMap contributors'
});

// Camada escura
const darkLayer = L.tileLayer('https://tile.jawg.io/jawg-dark/{z}/{x}/{y}{r}.png?access-token=Fr35xfUxIv64aS7qhlbFS5QxTHFFMHLFzVTYxA4UsZGE3Dr3Gi7ccrJbtfIQaOnK', {
    attribution: '© JawgMaps, OpenStreetMap contributors'
});

// Adicionar camada padrão (light) ao mapa
lightLayer.addTo(map);

// Controle para alternar entre as camadas
const baseMaps = {
    "Light Map": lightLayer,
    "Dark Map": darkLayer
};

L.control.layers(baseMaps).addTo(map);

// Verificar se há hotéis para mostrar
if (hotels.length === 0 && tours.length === 0) {
    const noHotelsPopup = L.popup()
        .setLatLng(map.getCenter())
        .setContent("No hotels found.")
        .openOn(map);
    
    const noToursPopup = L.popup()
        .setLatLng(map.getCenter())
        .setContent("No tours found.")
        .openOn(map);
} else {

    hotels.forEach(hotel => {
        const popupContent = `
            <b>${hotel.name}</b><br>
            <div class="hotelPage">
                <a href="${hotel.url}" class="btn btn-primary custom-button">See Hotel</a>
            </div>
        `;

        const marker = L.marker([hotel.latitude, hotel.longitude], { icon: hotelIcon })
            .addTo(map)
            .bindPopup(popupContent);
    });

    tours.forEach(tour => {
        const popupContent = `
            <b>${tour.name}</b><br>
            <div class="hotelPage">
                <a href="${tour.url}" class="btn btn-primary custom-button">See Tour</a>
            </div>
        `;

        const marker = L.marker([tour.latitude, tour.longitude], { icon: tourIcon })
            .addTo(map)
            .bindPopup(popupContent);
    });
}

// Atualizar os ícones quando o mapa mudar de camada
map.on('layeradd', function(e) {});