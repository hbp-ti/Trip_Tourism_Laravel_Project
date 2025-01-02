document.addEventListener("DOMContentLoaded", () => {
    const addHotelSection = document.getElementById("add-hotel");
    const addTourSection = document.getElementById("add-tour");
    const deleteItem = document.getElementById("delete-item");
    const hotelsSection = document.getElementById("hotels-section");
    const toursSection = document.getElementById("tours-section");
    const hotelsPagination = document.getElementById("hotels-pagination");
    const toursPagination = document.getElementById("tours-pagination");

    const addHotelLink = document.getElementById("add-hotel-link");
    const addTourLink = document.getElementById("add-tour-link");
    const deleteItemLink = document.getElementById("delete-item-link");

    // Evento de paginação para hotéis
    hotelsPagination.addEventListener("click", (e) => {
        if (e.target.tagName === "A") {
            e.preventDefault();
            const url = e.target.getAttribute("href");
            loadHotelsPage(url);
        }
    });

    // Evento de paginação para tours
    toursPagination.addEventListener("click", (e) => {
        if (e.target.tagName === "A") {
            e.preventDefault();
            const url = e.target.getAttribute("href");
            loadToursPage(url);
        }
    });

    // Função para carregar uma nova página de hotéis
    function loadHotelsPage(url) {
        fetch(url)
            .then((response) => response.text())
            .then((data) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                const newHotelsTableBody = doc.querySelector("#hotels-table-body");
                const newHotelsPagination = doc.querySelector("#hotels-pagination");

                document.getElementById("hotels-table-body").innerHTML = newHotelsTableBody.innerHTML;
                document.getElementById("hotels-pagination").innerHTML = newHotelsPagination.innerHTML;
            })
            .catch((error) => console.error("Error loading hotels page:", error));
    }

    // Função para carregar uma nova página de tours
    function loadToursPage(url) {
        fetch(url)
            .then((response) => response.text())
            .then((data) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                const newToursTableBody = doc.querySelector("#tours-table-body");
                const newToursPagination = doc.querySelector("#tours-pagination");

                document.getElementById("tours-table-body").innerHTML = newToursTableBody.innerHTML;
                document.getElementById("tours-pagination").innerHTML = newToursPagination.innerHTML;
            })
            .catch((error) => console.error("Error loading tours page:", error));
    }

    // Evento para mostrar "Add Hotel"
    addHotelLink.addEventListener("click", (e) => {
        e.preventDefault();
        addHotelSection.style.display = "block";
        addTourSection.style.display = "none";
        deleteItem.style.display = "none";
        hotelsSection.style.display = "none";
        toursSection.style.display = "none";
    });

    // Evento para mostrar "Add Tour"
    addTourLink.addEventListener("click", (e) => {
        e.preventDefault();
        addHotelSection.style.display = "none";
        addTourSection.style.display = "block";
        deleteItem.style.display = "none";
        hotelsSection.style.display = "none";
        toursSection.style.display = "none";
    });

    // Evento para mostrar "Delete Item"
    deleteItemLink.addEventListener("click", (e) => {
        e.preventDefault();
        addHotelSection.style.display = "none";
        addTourSection.style.display = "none";
        deleteItem.style.display = "block";
        hotelsSection.style = "block";
        toursSection.style = "block";
    });

});