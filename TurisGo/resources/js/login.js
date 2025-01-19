$(document).ready(function () {
    
    // Referências aos elementos
    const languageToggle = $('#languageToggle');
    const languageDropdown = $('#languageDropdown');
    const profileCircle = $('.profile-circle');
    const profileDropdown = $('.dropdown-menu');

    // Abrir/Fechar Language Dropdown
    languageToggle.on('click', function (event) {
        event.preventDefault();
        // Fecha o dropdown de perfil, se estiver aberto
        profileDropdown.hide();
        languageDropdown.toggle();
    });

    // Abrir/Fechar Profile Dropdown
    profileCircle.on('click', function (event) {
        event.stopPropagation();
        // Fecha o dropdown de linguagem, se estiver aberto
        languageDropdown.hide();
        profileDropdown.toggle();
    });

    // Fechar dropdowns ao clicar fora
    $(document).on('click', function (event) {
        if (
            !languageDropdown.is(event.target) &&
            !languageDropdown.has(event.target).length &&
            !languageToggle.is(event.target)
        ) {
            languageDropdown.hide();
        }
        if (
            !profileDropdown.is(event.target) &&
            !profileDropdown.has(event.target).length &&
            !profileCircle.is(event.target)
        ) {
            profileDropdown.hide();
        }
    });

    languageDropdown.on('click', function (e) {
        e.stopPropagation();
    });
    profileDropdown.on('click', function (e) {
        e.stopPropagation();
    });
    
// 4. Sticky Navbar and Language Image Swap
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
