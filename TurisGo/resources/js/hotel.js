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

// Fechar todos os dropdowns ao clicar fora
window.addEventListener('click', function () {
    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
        dropdown.classList.remove('show');
    });
});

// Funções para ordenar (placeholder)
function sortByPriceAsc() {
    console.log("Sorting by Price: Low to High");
}

function sortByPriceDesc() {
    console.log("Sorting by Price: High to Low");
}

function sortAlphabetically() {
    console.log("Sorting Alphabetically");
}

function sortByMostBooked() {
    console.log("Sorting by Most Booked");
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