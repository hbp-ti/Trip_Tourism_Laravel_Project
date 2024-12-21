// Inicializar o mapa
const map = L.map('map').setView([40.641, -8.653], 13); // Coordenadas iniciais (Aveiro)

// Criar o ícone personalizado
const hotelIcon = L.icon({
    iconUrl: '/images/hotelMarkerMap.png', // Caminho para o ícone do hotel
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
if (hotels.length === 0) {
    const noHotelsPopup = L.popup()
        .setLatLng(map.getCenter())
        .setContent("No hotels found.")
        .openOn(map);
} else {
    // Adicionar marcadores para cada hotel no mapa
    hotels.forEach(hotel => {
        // Criar o conteúdo do popup com o nome do hotel e o botão para redirecionamento
        const popupContent = `
            <b>${hotel.name}</b><br>
            <div class="hotelPage">
                <a href="${hotel.url}" class="btn btn-primary custom-button">See Hotel</a>
            </div>
        `;
        
        // Adicionando marcador para o hotel com o ícone personalizado
        const marker = L.marker([hotel.latitude, hotel.longitude], { icon: hotelIcon })
            .addTo(map)
            .bindPopup(popupContent);
    });
}

// Atualizar os ícones quando o mapa mudar de camada
map.on('layeradd', function(e) {});