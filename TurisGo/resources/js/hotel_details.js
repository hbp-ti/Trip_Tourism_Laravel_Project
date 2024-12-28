$(document).ready(function () {
  let currentIndex = 0;
  const $images = $('.slider-image');
  const $dots = $('.dot');

  // Função para mostrar a imagem atual e atualizar os pontos de navegação
  function showImage(index) {
    $images.addClass('hidden'); // Ocultar todas as imagens
    $dots.removeClass('active-dot'); // Remover a classe ativa dos pontos

    $($images[index]).removeClass('hidden'); // Mostrar a imagem atual
    $($dots[index]).addClass('active-dot'); // Ativar o ponto correspondente
  }

  // Função para mostrar a imagem anterior
  function prevImage() {
    currentIndex = (currentIndex === 0) ? $images.length - 1 : currentIndex - 1;
    showImage(currentIndex);
  }

  // Função para mostrar a próxima imagem
  function nextImage() {
    currentIndex = (currentIndex === $images.length - 1) ? 0 : currentIndex + 1;
    showImage(currentIndex);
  }

  // Evento para as setas de navegação
  $('.prev').click(function () {
    prevImage();
  });

  $('.next').click(function () {
    nextImage();
  });

  // Evento para os pontos de navegação
  $dots.each(function (index) {
    $(this).click(function () {
      currentIndex = index;
      showImage(currentIndex);
    });
  });

  // Mostrar a primeira imagem inicialmente
  showImage(currentIndex);

});

$(document).ready(function () {
  const $addReviewButton = $('#add-review-btn');
  const $reviewPopup = $('#reviewPopup');
  const $closePopupButton = $('#closeReviewPopup');

  if ($addReviewButton.length && $reviewPopup.length) {
      // Exibir o popup quando o botão for clicado
      $addReviewButton.on('click', function () {
          $reviewPopup.show();
      });

      // Fechar o popup ao clicar no botão de fechar
      $closePopupButton.on('click', function () {
          $reviewPopup.hide();
      });

      // Fechar o popup ao clicar fora dele
      $(window).on('click', function (e) {
          if ($(e.target).is($reviewPopup)) {
              $reviewPopup.hide();
          }
      });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".stars i");
  const ratingInput = document.getElementById("rating"); // Campo oculto para armazenar o rating

  // Adicionar evento de clique em cada estrela
  stars.forEach((star, index) => {
      star.addEventListener("click", function () {
          // Atualiza o valor do campo oculto com o número de estrelas selecionado
          ratingInput.value = index + 1;

          // Atualiza a aparência das estrelas
          updateStarAppearance(index);
      });
  });

  // Função para atualizar a aparência das estrelas
  function updateStarAppearance(selectedIndex) {
      stars.forEach((star, index) => {
          if (index <= selectedIndex) {
              star.classList.add("active"); // Adiciona a classe "active" para as estrelas até a selecionada
          } else {
              star.classList.remove("active"); // Remove a classe "active" para as estrelas acima da selecionada
          }
      });
  }
});


document.addEventListener("DOMContentLoaded", function () {
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

          // Traçar a rota do usuário até o hotel
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
              timeText.textContent = `${Math.floor(time)}:${Math.round((time % 1) * 60)}`;
          });
      }, function() {
          alert("Geolocalização falhou ou foi negada.");
      });
  } else {
      alert("Geolocalização não é suportada neste navegador.");
  }
});
