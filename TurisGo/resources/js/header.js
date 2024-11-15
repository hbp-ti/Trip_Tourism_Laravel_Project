$(document).ready(function () {
    const $languageToggle = $('#languageToggle');
    const $languageDropdown = $('#languageDropdown');

    $languageToggle.on('click', function (event) {
        event.preventDefault();
        $languageDropdown.toggle();
    });

    // Fecha o dropdown se clicar fora dele
    $(document).on('click', function (event) {
        if (!$languageDropdown.is(event.target) && !$languageDropdown.has(event.target).length &&
            !$languageToggle.is(event.target) && !$languageToggle.has(event.target).length) {
            $languageDropdown.hide();
        }
    });
});
