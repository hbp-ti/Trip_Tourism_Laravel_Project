document.addEventListener('DOMContentLoaded', function() {
    const carouselSlider = document.querySelector('.carousel-slider');
    const reviews = document.querySelectorAll('.review-card');
    let currentIndex = 0;
    const totalReviews = reviews.length;

    // Função para mudar a posição do slider
    function moveToNextReview() {
        if (currentIndex >= totalReviews - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }

        const offset = -currentIndex * 100; // Move o slider para a esquerda
        carouselSlider.style.transform = `translateX(${offset}%)`;
    }

    // Muda a review a cada 4 segundos
    setInterval(moveToNextReview, 4000);
});