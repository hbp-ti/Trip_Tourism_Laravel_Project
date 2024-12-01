
document.querySelector('.sortby-container').addEventListener('click', toggleDropdown);

// Adiciona o evento de clique ao ícone de "Sort By"
sortByIcon.addEventListener('click', toggleDropdown);

// Função para alternar a visibilidade do dropdown
function toggleDropdown() {
    document.getElementById("sortDropdown").classList.toggle("show");
}

// Fechar o dropdown se clicar fora dele
window.onclick = function(event) {
    if (!event.target.closest('.sortby-container')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

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