$(document).ready(function () {
    // Captura o clique no botão "Book Now"
    $('.book-now').on('click', function (e) {
        e.preventDefault();

        // Botão clicado
        const button = $(this);

        // Dados específicos do botão clicado
        const journey = button.data('journey');
        const leg = button.data('leg');
        // Coleta os valores do formulário
        const preference = $('select[name="preference"]').val();
        const passengers = $('input[name="passengers"]').val();
        const date = $('input[name="date"]').val();
        const travelClass = $('select[name="class"]').val();
        const from = $('select[name="from"]').val();
        const to = $('select[name="to"]').val();

        // Preparar os dados para enviar no AJAX
        const data = {
            journey: journey,
            leg: leg,
            preference: preference,
            passengers: passengers,
            date: date,
            class: travelClass,
            from: from,
            to: to,
        };

        // Realiza o AJAX request
        $.ajax({
            url: '/en/auth/cart/add',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                Swal.fire({
                    icon: 'success',
                    title: translate('Success!'),
                    text: translate('The item has been added to your cart!'),
                    confirmButtonText: translate('OK'),
                    confirmButtonColor: '#2081A5'
                }).then((result) => {
                    if (result.isConfirmed) {
                    }
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: translate('Error!'),
                    text: translate('An error occurred while adding the item to your cart!'),
                    confirmButtonText: translate('OK'),
                    confirmButtonColor: '#2081A5'
                }).then((result) => {
                    if (result.isConfirmed) {
                    }
                });
            }
        });
    });
});