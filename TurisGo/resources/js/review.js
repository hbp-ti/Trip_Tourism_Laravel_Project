document.addEventListener("DOMContentLoaded", function () {
    const openPopupButton = document.getElementById("openReviewPopup");
    const closePopupButton = document.getElementById("closeReviewPopup");
    const reviewPopup = document.getElementById("reviewPopup");

    if (openPopupButton && closePopupButton && reviewPopup) {
        openPopupButton.addEventListener("click", function () {
            reviewPopup.style.display = "block";
        });

        closePopupButton.addEventListener("click", function () {
            reviewPopup.style.display = "none";
        });

        window.addEventListener("click", function (e) {
            if (e.target === reviewPopup) {
                reviewPopup.style.display = "none";
            }
        });
    }
});
