// Adicionar evento em todos os contêineres de "sortby"
document.querySelectorAll('.sortby-container').forEach(container => {
    container.addEventListener('click', function (event) {
        // Fechar todos os dropdowns antes de abrir o atual
        document.querySelectorAll('.sortDropdown').forEach(dropdown => {
            dropdown.classList.remove('show');
        });

        // Abrir apenas o dropdown do container atual
        const dropdown = this.querySelector('.sortDropdown');
        dropdown.classList.toggle('show');

        // Impedir o evento de fechar o dropdown ao clicar dentro dele
        event.stopPropagation();
    });
});

window.addEventListener('click', function () {
    document.querySelectorAll('.sortDropdown').forEach(dropdown => {
        dropdown.classList.remove('show');
    });
});


// Funções para ordenar
function sortByPriceAsc() {
    // Lógica
}

function sortByPriceDesc() {
    // Lógica
}

function sortAlphabetically() {
    // Lógica
}

function sortByMostBooked() {
    // Lógica
}