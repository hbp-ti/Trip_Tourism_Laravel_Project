document.addEventListener("DOMContentLoaded", function() {
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

    // Alterando o comportamento de clique nos links do dropdown
    const sortLinks = document.querySelectorAll('.sortDropdown a');
    sortLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const sortType = this.getAttribute('href').split('sort=')[1]; // Pegando o valor do 'sort' da URL
            if (sortType === 'price_asc') {
                sortByPriceAsc();
            } else if (sortType === 'price_desc') {
                sortByPriceDesc();
            } else if (sortType === 'alphabetical') {
                sortAlphabetically();
            } else if (sortType === 'most_booked') {
                sortByMostBooked();
            }
        });
    });

    // Funções para ordenar
    function sortByPriceAsc() {
        const tours = document.querySelectorAll('.tourActivity-card');
        const sortedTours = Array.from(tours).sort((a, b) => {
            const priceA = parseFloat(a.querySelector('.price-tag').textContent.replace('€', '').trim());
            const priceB = parseFloat(b.querySelector('.price-tag').textContent.replace('€', '').trim());
            return priceA - priceB;
        });

        const container = document.querySelector('.single-column-container');
        sortedTours.forEach(tour => container.appendChild(tour));
    }

    function sortByPriceDesc() {
        const tours = document.querySelectorAll('.tourActivity-card');
        const sortedTours = Array.from(tours).sort((a, b) => {
            const priceA = parseFloat(a.querySelector('.price-tag').textContent.replace('€', '').trim());
            const priceB = parseFloat(b.querySelector('.price-tag').textContent.replace('€', '').trim());
            return priceB - priceA;
        });

        const container = document.querySelector('.single-column-container');
        sortedTours.forEach(tour => container.appendChild(tour));
    }

    function sortAlphabetically() {
        const tours = document.querySelectorAll('.tourActivity-card');
        const sortedTours = Array.from(tours).sort((a, b) => {
            const nameA = a.querySelector('h2').textContent.trim().toLowerCase();
            const nameB = b.querySelector('h2').textContent.trim().toLowerCase();
            return nameA.localeCompare(nameB);
        });

        const container = document.querySelector('.single-column-container');
        sortedTours.forEach(tour => container.appendChild(tour));
    }

    function sortByMostBooked() {
        const tours = document.querySelectorAll('.tourActivity-card');
        const sortedTours = Array.from(tours).sort((a, b) => {
            const bookingsA = parseInt(a.getAttribute('data-bookings')); 
            const bookingsB = parseInt(b.getAttribute('data-bookings'));
            return bookingsB - bookingsA;
        });

        const container = document.querySelector('.single-column-container');
        sortedTours.forEach(tour => container.appendChild(tour));
    }

    // Expondo as funções globalmente para os eventos onclick
    window.sortByPriceAsc = sortByPriceAsc;
    window.sortByPriceDesc = sortByPriceDesc;
    window.sortAlphabetically = sortAlphabetically;
    window.sortByMostBooked = sortByMostBooked;
});
