$(document).ready(function () {
    const $termsLink = $('#terms-link');
    const $termsModal = $('#termsModal');
    const $closeModalButton = $('#closeModal');

    $termsLink.on('click', function (event) {
        event.preventDefault();
        $termsModal.css('display', 'flex');
    });

    $closeModalButton.on('click', function () {
        $termsModal.css('display', 'none');
    });

    $(window).on('click', function (event) {
        if ($(event.target).is($termsModal[0])) {
            $termsModal.css('display', 'none');
        }
    });
});
