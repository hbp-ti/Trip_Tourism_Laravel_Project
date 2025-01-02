// Trata a cor de fundo do método de pagamento escolhido
const methods = document.querySelectorAll('.method');

methods.forEach(method => {
    method.addEventListener('click', () => {
        // Remove a classe 'active' de todos os métodos
        methods.forEach(m => m.classList.remove('active'));

        // Adiciona a classe 'active' ao método selecionado
        method.classList.add('active');
    });
});

$(document).ready(function () {
    // Atualiza o método de pagamento selecionado
    $(document).on('click', '.method', function () {
        const paymentSelected = $(this).attr('id'); // Obtém o ID do método clicado
        if (['mbway', 'multibanco', 'paypal'].includes(paymentSelected)) {
            $('#paymentMethod').val(paymentSelected); // Define o valor no input hidden
        }
    });

    // Função para abrir um popup centralizado
    function openPopup(url, title, width, height) {
        // Calcula a posição central na tela
        const left = (window.screen.width / 2) - (width / 2);
        const top = (window.screen.height / 2) - (height / 2);

        // Abre o popup com as dimensões e posição especificadas
        window.open(url, title, `width=${width},height=${height},top=${top},left=${left}`);
    }

	$('#buttonContinue').on('click', function (e) {
        if (!$('#aware').is(':checked')) { // se #aware não estiver ativado
            e.preventDefault();
            Swal.fire({
                title: translate('Error!'),
                text: translate('You have to accept the disclaimer.'),
                icon: 'warning',
                confirmButtonText: translate('OK'),
                confirmButtonColor: '#C76A37'
            });
        }
    });
});

document.querySelector('input[type="number"]').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, ''); // Remove caracteres não numéricos
});
