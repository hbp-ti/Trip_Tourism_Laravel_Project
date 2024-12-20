// Trata a cor de fundo do método de pagamento escolhido
const methods = document.querySelectorAll('.method');

methods.forEach(method => {
    method.addEventListener('click', () => {
        methods.forEach(m => m.classList.remove('active'));

        method.classList.add('active');
    });
});

$(document).ready(function () {
    $(document).on('click', '.method', function () {
        let paymentSelected = $(this).attr('id');
        if (paymentSelected == 'mbway') {
            $('#paymentMethod').val(paymentSelected);
        } else if (paymentSelected == 'multibanco') {
            $('#paymentMethod').val(paymentSelected);
        } else if (paymentSelected == 'paypal') {
            $('#paymentMethod').val(paymentSelected);
        }
    });

    function openPopup(url, title, width, height) {
        // Calcula a posição central na tela
        const left = (window.screen.width / 2) - (width / 2);
        const top = (window.screen.height / 2) - (height / 2);

        // Abre o popup com as dimensões e a posição especificadas
        window.open(url, title, `width=${width},height=${height},top=${top},left=${left}`);
    }

});

