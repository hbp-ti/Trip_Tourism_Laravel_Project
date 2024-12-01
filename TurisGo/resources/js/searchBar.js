document.addEventListener("DOMContentLoaded", () => {
    const searchButton = document.querySelector(".search-button button");
    const locationInput = document.getElementById("location");
    const checkinInput = document.getElementById("checkin");
    const checkoutInput = document.getElementById("checkout");
    const peopleSelect = document.getElementById("people");

    searchButton.addEventListener("click", () => {
        const checkin = checkinInput.value.trim();
        const checkout = checkoutInput.value.trim();
        const people = peopleSelect.value.trim();
        const location = locationInput.value.trim();

        if (!checkin || !checkout || !people || !location) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please fill in all required fields before searching!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#207391'
            });
        } else {
            window.location.href = "hotels";
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