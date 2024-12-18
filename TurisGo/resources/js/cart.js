document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();  // Impede o envio do formulário imediato

        // Mostra o popup de confirmação
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you really want to remove this item from your cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, keep it',
            reverseButtons: true,
            confirmButtonColor: '#C76A37'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});

document.querySelector('.checkout-btn').addEventListener('click', function(event) {
    event.preventDefault();  // Impede o envio imediato da ação do botão

    // Exibe o popup de confirmação
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to proceed to payment?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed to payment!',
        cancelButtonText: 'No, go back',
        reverseButtons: true,
        confirmButtonColor: '#C76A37'  // Cor personalizada para o botão de confirmação
    }).then((result) => {
        if (result.isConfirmed) {
            // Se o usuário confirmar, você pode redirecionar para o pagamento ou enviar o formulário
            window.location.href = '/payment1';  // Substitua '/payment' pela URL real do pagamento
        }
    });
});