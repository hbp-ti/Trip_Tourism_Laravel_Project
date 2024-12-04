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
document.getElementById('changetour').addEventListener('click', function () {
    const uploadInput = document.getElementById('uploadInput');
    if (uploadInput) {
        uploadInput.click();
    } else {
        console.error('O input de ficheiro não foi encontrado!');
    }
});

document.getElementById('uploadInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.querySelector('.profile-pic').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const changePasswordButton = document.getElementById('changePasswordButton');
    const passwordPopup = document.getElementById('passwordPopup');
    const cancelChangePassword = document.getElementById('cancelChangePassword');
    const confirmChangePassword = document.getElementById('confirmChangePassword');

    changePasswordButton.addEventListener('click', () => {
        passwordPopup.classList.remove('hidden');
    });

    cancelChangePassword.addEventListener('click', () => {
        passwordPopup.classList.add('hidden');
    });

    confirmChangePassword.addEventListener('click', () => {
        const oldPassword = document.getElementById('oldPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        // Simular envio dos dados para o servidor
        alert("Password changed successfully!");

        // Fechar o popup após a confirmação
        passwordPopup.classList.add('hidden');
    });
});

