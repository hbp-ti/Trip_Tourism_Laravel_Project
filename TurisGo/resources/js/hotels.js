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
  var sortBy = $('select[name="sort_by"]').val(); // Caso haja um campo para ordenação

  // Construir a URL com os parâmetros de pesquisa
  var url = new URL($(this).attr('href'));
  url.searchParams.set('location', location || '');
  url.searchParams.set('checkin', checkin || '');
  url.searchParams.set('checkout', checkout || '');
  url.searchParams.set('people', people || '');
  url.searchParams.set('sort_by', sortBy || '');

  // Atualizar a URL do botão para preservar os parâmetros
  $(this).attr('href', url.toString());

  $.ajax({
      url: url.toString(),
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
