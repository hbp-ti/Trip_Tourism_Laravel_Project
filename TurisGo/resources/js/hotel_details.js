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

