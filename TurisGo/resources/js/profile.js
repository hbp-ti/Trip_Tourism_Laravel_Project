$(document).ready(function () {
    // Função que alterna entre modo de leitura e edição
    $('#editButton').click(function () {
        let inputs = $('.profile-info input'); // Seleciona todos os inputs
        let isEditable = false;

        // Verifica se algum campo está em modo de edição
        inputs.each(function () {
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
document.getElementById('changeprofilepic').addEventListener('click', function () {
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
            // Exibe a imagem na tela
            document.querySelector('.profile-pic').src = e.target.result;

            // Exibe o popup de confirmação com SweetAlert2
            Swal.fire({
                title: 'Do you want to change your profile picture?',
                text: 'If you confirm, your profile picture will be updated.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, keep it',
                confirmButtonColor: '#ff8000',
                cancelButtonColor: '#2081A5'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateProfilePicture(file);
                } else {
                    document.querySelector('.profile-pic').src = "{{ asset('images/profile.png') }}";
                }
            });
        };
        reader.readAsDataURL(file);
    }
});
/*
// Função para enviar a imagem ao servidor
function updateProfilePicture(file) {
    const locale = document.documentElement.lang;
    const formData = new FormData();
    formData.append('profile_picture', file);

    // Exemplo de AJAX para enviar a imagem para o controlador
    $.ajax({
        url: '/' + locale + '/auth/profile/update-picture',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Profile Picture Updated!',
                text: 'Your profile picture has been updated successfully.'
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'There was an error updating your profile picture. Please try again.'
            });
        }
    });
}*/
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
            Swal.fire({
                icon: 'error',
                title: 'Passwords do not match!',
                text: 'Please make sure the passwords match before submitting.',
                confirmButtonText: 'Try again'
            });
            return;
        }

        passwordPopup.classList.add('hidden');
    });
});

