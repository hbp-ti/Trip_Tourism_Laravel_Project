// Obtém os elementos do botão de filtro, da barra lateral e do fundo
const filterButton = document.querySelector('.filter');
const sidebar = document.getElementById('sidebar');
const blurBackground = document.getElementById('blur-background');

// Adiciona o evento de clique ao botão de filtro
filterButton.addEventListener('click', () => {
    // Alterna a classe 'open' para abrir ou fechar a sidebar
    sidebar.classList.toggle('open');
    // Alterna a classe 'active' para aplicar ou remover o blur
    blurBackground.classList.toggle('active');
});

// Caso você queira fechar a sidebar clicando fora dela
window.addEventListener('click', (event) => {
    if (!sidebar.contains(event.target) && !filterButton.contains(event.target)) {
        // Remove a classe 'open' da sidebar e o efeito de blur
        sidebar.classList.remove('open');
        blurBackground.classList.remove('active');
    }
});