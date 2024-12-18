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

 // Select all elements with the "i" tag and store them in a NodeList called "stars"
 const stars = document.querySelectorAll(".stars i");

 // Loop through the "stars" NodeList
 stars.forEach((star, index1) => {
   // Add an event listener that runs a function when the "click" event is triggered
   star.addEventListener("click", () => {
     // Loop through the "stars" NodeList Again
     stars.forEach((star, index2) => {
       // Add the "active" class to the clicked star and any stars with a lower index
       // and remove the "active" class from any stars with a higher index
       index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
     });
   });
 });