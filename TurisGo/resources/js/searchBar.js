document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("search-form");
    const locationInput = document.getElementById("location");
    const checkinInput = document.getElementById("checkin");
    const checkoutInput = document.getElementById("checkout");
    const peopleSelect = document.getElementById("people");
    const searchButton = document.getElementById("searchButton");

    // Função para obter os parâmetros da URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Preenche os campos do formulário com os parâmetros da URL
    function populateFormFields() {
        const location = getQueryParam("location");
        const checkin = getQueryParam("checkin");
        const checkout = getQueryParam("checkout");
        const people = getQueryParam("people");

        if (location) locationInput.value = location;
        if (checkin) checkinInput.value = checkin;
        if (checkout) checkoutInput.value = checkout;
        if (people) peopleSelect.value = people;
    }

    // Chama a função para preencher os campos ao carregar a página
    populateFormFields();

    searchButton.addEventListener("click", (event) => {
        event.preventDefault(); // Previne o envio do formulário, já que não estamos usando um form com submit
        const checkin = checkinInput.value.trim();
        const checkout = checkoutInput.value.trim();
        const people = peopleSelect.value.trim();
        const location = locationInput.value.trim();

        // Verificação de campos vazios
        if (!checkin || !checkout || !people || !location) {
            Swal.fire({
                icon: 'warning',
                title: 'Informação em falta',
                text: 'Por favor, preencha todos os campos obrigatórios antes de procurar!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#207391'
            });
        } else {
            const url = new URL("hotels", window.location.origin);
            url.searchParams.append("location", location);
            url.searchParams.append("checkin", checkin);
            url.searchParams.append("checkout", checkout);
            url.searchParams.append("people", people);

            // Redireciona para a página de pesquisa com os parâmetros
            window.location.href = url.toString();
        }
    });

    // Inicializa o flatpickr para check-in
    flatpickr(checkinInput, {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: (selectedDates) => {
            const checkinDate = selectedDates[0];
            if (checkinDate) {
                checkoutFlatpickr.set("minDate", checkinDate);
            }
        }
    });

    // Inicializa o flatpickr para check-out
    const checkoutFlatpickr = flatpickr(checkoutInput, {
        dateFormat: "Y-m-d",
        minDate: "today"
    });
});