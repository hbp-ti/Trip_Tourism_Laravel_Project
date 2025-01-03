// Adicionar evento em todos os contêineres de "sortby"
document.querySelectorAll('.sortby-container').forEach(container => {
  container.addEventListener('click', function (event) {
    // Fechar todos os dropdowns antes de abrir o atual
    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
      dropdown.classList.remove('show');
    });

    // Abrir apenas o dropdown do container atual
    const dropdown = this.querySelector('.dropdown-content');
    if (dropdown) {
      dropdown.classList.toggle('show');
    }

    // Impedir que o clique se propague para o evento global
    event.stopPropagation();
  });
});

$(document).on('click', '.load-more', function(e) {
  e.preventDefault();

  // Obter os parâmetros de pesquisa (location, checkin, checkout, people)
  var location = $('select[name="location"]').val();
  var checkin = $('input[name="checkin"]').val();
  var checkout = $('input[name="checkout"]').val();
  var people = $('select[name="people"]').val();
  var sortBy = $('select[name="sort_by"]').val();  // Caso haja um campo para ordenação

  var url = $(this).attr('href').split('?')[0] + '?' +
            'location=' + location +
            '&checkin=' + checkin +
            '&checkout=' + checkout +
            '&people=' + people +
            '&sort_by=' + sortBy;

  $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
          // Adiciona os novos hotéis ao final da lista existente
          $('.hotel-list').append(response.html);

          // Atualiza o link para carregar mais, caso exista
          if (response.next_page) {
              $('.load-more').attr('href', response.next_page);
          } else {
              $('.load-more').remove(); // Se não houver mais páginas, remove o botão
          }
      }
  });
});

// Fechar todos os dropdowns ao clicar fora
window.addEventListener('click', function () {
  document.querySelectorAll('.dropdown-content').forEach(dropdown => {
    dropdown.classList.remove('show');
  });
});

// Funções para ordenar (placeholder)
function sortByPriceAsc() {
  console.log("Sorting by Price: Low to High");
  applySort('price_asc');
}

function sortByPriceDesc() {
  console.log("Sorting by Price: High to Low");
  applySort('price_desc');
}

function sortAlphabetically() {
  console.log("Sorting Alphabetically");
  applySort('alphabetical');
}

function sortByMostBooked() {
  console.log("Sorting by Most Booked");
  applySort('most_booked');
}


// Selecione os elementos da sidebar, do blur e do botão de toggle
const sidebar = document.getElementById('sidebar');
const toggleSidebar = document.getElementById('toggle-sidebar');
const blurOverlay = document.getElementById('blur-overlay');

// Adicionar evento para alternar a barra lateral
toggleSidebar.addEventListener('click', (event) => {
  // Impede que o evento se propague
  event.stopPropagation();
  // Alterna a classe 'active' para a sidebar
  sidebar.classList.toggle('active');
  // Alterna a exibição do desfoque
  if (sidebar.classList.contains('active')) {
    blurOverlay.style.display = 'block';
  } else {
    blurOverlay.style.display = 'none';
  }
});

// Fechar a barra lateral ao clicar fora dela (no blur)
window.addEventListener('click', () => {
  if (sidebar.classList.contains('active')) {
    sidebar.classList.remove('active');
    blurOverlay.style.display = 'none'; // Oculta o desfoque
  }
});

// Impedir que o clique na sidebar feche ela
sidebar.addEventListener('click', (event) => {
  event.stopPropagation();
});
// Fechar a sidebar clicando no overlay de desfoque
blurOverlay.addEventListener('click', () => {
  sidebar.classList.remove('active');
  blurOverlay.style.display = 'none'; // Oculta o desfoque
});

document.addEventListener("DOMContentLoaded", function () {
  const openPopupButton = document.getElementById("openReviewPopup");
  const closePopupButton = document.getElementById("closeReviewPopup");
  const reviewPopup = document.getElementById("reviewPopup");

  if (openPopupButton && closePopupButton && reviewPopup) {
    openPopupButton.addEventListener("click", function () {
      reviewPopup.style.display = "block";
    });

    closePopupButton.addEventListener("click", function () {
      reviewPopup.style.display = "none";
    });

    window.addEventListener("click", function (e) {
      if (e.target === reviewPopup) {
        reviewPopup.style.display = "none";
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

    // Adicionar efeito de hover para as estrelas
    star.addEventListener("mouseover", function () {
      updateStarAppearance(index, true);
    });

    // Remover efeito de hover quando o mouse sair da estrela
    star.addEventListener("mouseout", function () {
      const currentRating = parseInt(ratingInput.value);
      updateStarAppearance(currentRating - 1); // Mantém a aparência com a avaliação atual
    });
  });

  // Função para atualizar a aparência das estrelas
  function updateStarAppearance(selectedIndex, hover = false) {
    stars.forEach((star, index) => {
      if (index <= selectedIndex) {
        star.classList.add("active"); // Adiciona a classe "active" para as estrelas até a selecionada
      } else {
        star.classList.remove("active"); // Remove a classe "active" para as estrelas acima da selecionada
      }

      // Efeito de hover
      if (hover) {
        star.classList.add("hover");
      } else {
        star.classList.remove("hover");
      }
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const filterForm = document.getElementById('apply-filters-btn');

  // Evento para capturar mudanças nos filtros
  filterForm.addEventListener('change', function () {
    // Coletar os valores dos filtros
    const priceRange = document.querySelector('select[name="price_range"]').value;
    const hotelStars = document.querySelector('select[name="hotel_stars"]').value;
    const guestRatings = document.querySelector('select[name="guest_ratings"]').value;

    // Coletar os valores dos checkboxes de facilidades
    const breakfastIncluded = document.querySelector('input[name="breakfast_included"]').checked ? 1 : 0;
    const freeWifi = document.querySelector('input[name="free_wifi"]').checked ? 1 : 0;
    const parking = document.querySelector('input[name="parking"]').checked ? 1 : 0;
    const gym = document.querySelector('input[name="gym"]').checked ? 1 : 0;
    const pool = document.querySelector('input[name="pool"]').checked ? 1 : 0;
    const spaWellness = document.querySelector('input[name="spa_wellness"]').checked ? 1 : 0;
    const hotelRestaurant = document.querySelector('input[name="hotel_restaurant"]').checked ? 1 : 0;
    const bar = document.querySelector('input[name="bar"]').checked ? 1 : 0;

    // Coletar os valores dos checkboxes de política de cancelamento
    const freeCancellation = document.querySelector('input[name="free_cancellation"]').checked ? 1 : 0;
    const refundableReservations = document.querySelector('input[name="refundable_reservations"]').checked ? 1 : 0;

    // Construir o URL com os parâmetros de filtro
    const url = new URL(window.location.href.split('?')[0]);

    // Adicionar parâmetros de consulta apenas se os valores forem diferentes de "null" ou "0" (nenhum filtro selecionado)
    if (priceRange !== '0') url.searchParams.set('price_range', priceRange);
    if (hotelStars !== '0') url.searchParams.set('hotel_stars', hotelStars);
    if (guestRatings !== '0') url.searchParams.set('guest_ratings', guestRatings);
    if (breakfastIncluded) url.searchParams.set('breakfast_included', breakfastIncluded);
    if (freeWifi) url.searchParams.set('free_wifi', freeWifi);
    if (parking) url.searchParams.set('parking', parking);
    if (gym) url.searchParams.set('gym', gym);
    if (pool) url.searchParams.set('pool', pool);
    if (spaWellness) url.searchParams.set('spa_wellness', spaWellness);
    if (hotelRestaurant) url.searchParams.set('hotel_restaurant', hotelRestaurant);
    if (bar) url.searchParams.set('bar', bar);
    if (freeCancellation) url.searchParams.set('free_cancellation', freeCancellation);
    if (refundableReservations) url.searchParams.set('refundable_reservations', refundableReservations);

    // Atualizar a URL com os novos parâmetros de filtro
    window.history.replaceState({}, '', url);
  });

  // Submissão do formulário ao clicar no botão "Apply Filters"
  filterForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Impedir o envio padrão do formulário

    // Coletar os filtros e enviar via AJAX, caso necessário
    const priceRange = document.querySelector('select[name="price_range"]').value;
    const hotelStars = document.querySelector('select[name="hotel_stars"]').value;
    const guestRatings = document.querySelector('select[name="guest_ratings"]').value;

    // Obter os valores dos filtros de checkbox
    const breakfastIncluded = document.querySelector('input[name="breakfast_included"]').checked ? 1 : 0;
    const freeWifi = document.querySelector('input[name="free_wifi"]').checked ? 1 : 0;
    const parking = document.querySelector('input[name="parking"]').checked ? 1 : 0;
    const gym = document.querySelector('input[name="gym"]').checked ? 1 : 0;
    const pool = document.querySelector('input[name="pool"]').checked ? 1 : 0;
    const spaWellness = document.querySelector('input[name="spa_wellness"]').checked ? 1 : 0;
    const hotelRestaurant = document.querySelector('input[name="hotel_restaurant"]').checked ? 1 : 0;
    const bar = document.querySelector('input[name="bar"]').checked ? 1 : 0;
    const freeCancellation = document.querySelector('input[name="free_cancellation"]').checked ? 1 : 0;
    const refundableReservations = document.querySelector('input[name="refundable_reservations"]').checked ? 1 : 0;

    const url = $(filterForm).attr('action').split('?')[0] + '?';
    const queryString = [
      `price_range=${priceRange}`,
      `hotel_stars=${hotelStars}`,
      `guest_ratings=${guestRatings}`,
      `breakfast_included=${breakfastIncluded}`,
      `free_wifi=${freeWifi}`,
      `parking=${parking}`,
      `gym=${gym}`,
      `pool=${pool}`,
      `spa_wellness=${spaWellness}`,
      `hotel_restaurant=${hotelRestaurant}`,
      `bar=${bar}`,
      `free_cancellation=${freeCancellation}`,
      `refundable_reservations=${refundableReservations}`
    ].join('&');

    // Enviar a requisição com os filtros aplicados via AJAX
    $.ajax({
      url: url + queryString,
      type: 'GET',
      success: function (response) {
        // Atualizar a página com os resultados filtrados
        $('.hotel-list').html(response.html);
      }
    });
  });
});