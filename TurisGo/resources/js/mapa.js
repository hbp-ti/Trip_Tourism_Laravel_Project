// Inicializar o mapa
const map = L.map('map').setView([40.641, -8.653], 13); // Coordenadas iniciais (Aveiro)

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

// Mensagem para o caso de não haver hotéis
const noHotelsPopup = L.popup()
    .setLatLng(map.getCenter())
    .setContent("No hotels found.")
    .openOn(map);