document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById("toggleFilters");
    const filtersContainer = document.getElementById("filtersContainer");

    toggleButton.addEventListener("click", function() {
        // Alterna a classe "hidden" (se estiver, remove; se não estiver, adiciona)
        filtersContainer.classList.toggle("hidden");

        // Se estiver hidden depois de alternar, significa que escondemos. Então texto vira "Show Filters"
        if (filtersContainer.classList.contains("hidden")) {
            toggleButton.textContent = "Show Filters";
        } else {
            // Caso contrário, texto vira "Hide Filters"
            toggleButton.textContent = "Hide Filters";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".transport-button");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            // Remove a classe "active" de todos os botões
            buttons.forEach(btn => btn.classList.remove("active"));
            // Adiciona a classe "active" apenas ao botão clicado
            button.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const carButton = document.getElementById("carButton");
    const trainButton = document.getElementById("trainButton");
    const walkButton = document.getElementById("walkButton");
    const optionsContainer = document.getElementById("optionsContainer");
    const trainInfo = document.getElementById("trainInfo"); // Caixa do comboio

    // Função para mostrar ou esconder as opções e a caixa do comboio
    function toggleOptions(selectedButton) {
        if (selectedButton === "car") {
            optionsContainer.classList.remove("hidden"); // Mostra opções
            trainInfo.classList.add("hidden"); // Esconde comboio
        } else if (selectedButton === "train") {
            optionsContainer.classList.add("hidden"); // Esconde opções
            trainInfo.classList.remove("hidden"); // Mostra comboio
        } else {
            optionsContainer.classList.add("hidden"); // Esconde opções
            trainInfo.classList.add("hidden"); // Esconde comboio
        }
    }

    // Eventos de clique
    carButton.addEventListener("click", () => {
        toggleOptions("car");
        carButton.classList.add("active");
        trainButton.classList.remove("active");
        walkButton.classList.remove("active");
    });

    trainButton.addEventListener("click", () => {
        toggleOptions("train");
        carButton.classList.remove("active");
        trainButton.classList.add("active");
        walkButton.classList.remove("active");
    });

    walkButton.addEventListener("click", () => {
        toggleOptions("walk");
        carButton.classList.remove("active");
        trainButton.classList.remove("active");
        walkButton.classList.add("active");
    });
});
