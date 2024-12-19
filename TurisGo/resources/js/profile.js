$(document).ready(function () {
    // Interceptar o evento de envio do formulário
    $('#changeinfoButton').click(function (event) {
        event.preventDefault(); // Previne o envio do formulário

        // Exibe o popup de confirmação usando SweetAlert2
        Swal.fire({
            title: 'Are you sure you want to update your information?',
            text: 'If you confirm, your profile information will be updated.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, keep it',
            confirmButtonColor: '#ff8000',
            cancelButtonColor: '#2081A5'
        }).then((result) => {
            // Se o usuário confirmar, submete o formulário
            if (result.isConfirmed) {
                // Submete o formulário
                $('form.profile-info').submit();
            }
        });
    });
});


document.getElementById('changeprofilepic').addEventListener('click', function (event) {
    // Previne o envio padrão do formulário
    event.preventDefault();

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
            // Atualiza visualmente a imagem com a nova antes de confirmar
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
                    // Envia o formulário após confirmação
                    const form = document.getElementById('profileForm');
                    form.submit();
                } else {
                    // Caso o usuário cancele, restaura a imagem original
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

