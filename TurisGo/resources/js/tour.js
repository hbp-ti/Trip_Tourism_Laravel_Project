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
  