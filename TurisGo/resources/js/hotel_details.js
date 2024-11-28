$(document).ready(function() {
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
    $('.prev').click(function() {
      prevImage();
    });
  
    $('.next').click(function() {
      nextImage();
    });
  
    // Evento para os pontos de navegação
    $dots.each(function(index) {
      $(this).click(function() {
        currentIndex = index;
        showImage(currentIndex);
      });
    });
  
    // Mostrar a primeira imagem inicialmente
    showImage(currentIndex);
  });
  