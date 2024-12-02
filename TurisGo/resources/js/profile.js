$(document).ready(function() {
    // Função que alterna entre modo de leitura e edição
    $('#editButton').click(function() {
        var inputs = $('.profile-info input'); // Seleciona todos os inputs
        var isEditable = false;

        // Verifica se algum campo está em modo de edição
        inputs.each(function() {
            if (!$(this).prop('readonly')) {
                isEditable = true;
            }
        });

        if (isEditable) {
            // Se já estiver em edição, desativa o modo de edição
            inputs.prop('readonly', true); // Coloca os campos em modo de leitura
            inputs.removeClass('editable'); // Remove a classe 'editable'
            $('#editButton').text('Edit'); // Muda o texto do botão para 'Edit'
        } else {
            // Se estiver em modo de leitura, ativa a edição
            inputs.prop('readonly', false); // Torna os campos editáveis
            inputs.addClass('editable'); // Adiciona a classe 'editable'
            $('#editButton').text('Save'); // Muda o texto do botão para 'Save'
        }
    });
});
