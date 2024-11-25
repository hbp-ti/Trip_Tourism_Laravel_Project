$(document).ready(function () {
    const $languageToggle = $('#languageToggle');
    const $languageDropdown = $('#languageDropdown');

    $languageToggle.on('click', function (event) {
        event.preventDefault();
        $languageDropdown.toggle();
    });

    // Fecha o dropdown se clicar fora dele
    $(document).on('click', function (event) {
        if (!$languageDropdown.is(event.target) && !$languageDropdown.has(event.target).length &&
            !$languageToggle.is(event.target) && !$languageToggle.has(event.target).length) {
            $languageDropdown.hide();
        }
    });

    // Abrir e fechar o dropdown ao clicar no círculo
    $('.profile-circle').on('click', function (e) {
        e.stopPropagation(); // Evita fechar o dropdown ao clicar no círculo
        $('.dropdown-menu').toggle(); // Alterna entre mostrar e ocultar
    });

    // Fechar o dropdown ao clicar fora dele
    $(document).on('click', function () {
        $('.dropdown-menu').hide(); // Fecha o dropdown
    });

    // Evitar que o dropdown feche ao clicar dentro dele
    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation(); // Impede o fechamento ao clicar dentro do menu
    });
});

document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.navbar');
        const languageImg = document.querySelector(".language-img");

        if (window.scrollY > 50) {
            header.classList.add('navbar-fixed');
            languageImg.src = languageImg.src.replace("languageSelection1.png", "languageSelection2.png");
        } else {
            header.classList.remove('navbar-fixed');
            languageImg.src = languageImg.src.replace("languageSelection2.png", "languageSelection1.png");
        }
    });

});

document.querySelectorAll('.nav-links li a').forEach(link => {
    link.addEventListener('click', function () {
        // Remove a classe 'active' de todos os links
        document.querySelectorAll('.nav-links li a').forEach(link => {
            link.classList.remove('active');
        });

        // Adiciona a classe 'active' no link clicado
        this.classList.add('active');
    });
});
