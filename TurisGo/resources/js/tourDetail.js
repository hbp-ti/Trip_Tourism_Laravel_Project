document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("toggleFilters");
    const filtersContainer = document.getElementById("filtersContainer");
    const mapContainer = document.getElementById("mapContainer");

    toggleButton.addEventListener("click", function () {
        filtersContainer.classList.toggle("hidden");
        toggleButton.textContent = filtersContainer.classList.contains("hidden")
            ? "Show Filters"
            : "Hide Filters";
    });
});