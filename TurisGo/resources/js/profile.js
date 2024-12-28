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
                    let profilePicUrl =
                        "{{ file_exists(public_path('storage/' . Auth::user()->image)) ? asset('storage/' . Auth::user()->image) : asset('images/default_user_image.png') }}";
                    document.querySelector('.profile-pic').src = profilePicUrl;
                }
            });
        };
        reader.readAsDataURL(file);
    }
});
$(document).ready(function () {

    $('#show-popup').on('click', function () {
        $('#popup-overlay').fadeIn();
        $('#popup').fadeIn();
    });

    $('#close-popup').on('click', function () {
        $('#popup').fadeOut();
        $('#popup-overlay').fadeOut();
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Botão para abrir o popup
    const changePasswordButton = document.getElementById('changePasswordButton');
    const passwordPopup = document.getElementById('passwordPopup');
    const cancelChangePassword = document.getElementById('cancelChangePassword');
    const popupOverlay = document.querySelector('.popup-overlay');

    // Função para mostrar o popup
    changePasswordButton.addEventListener('click', function () {
        passwordPopup.classList.remove('hidden');
        popupOverlay.style.display = 'block';
    });

    // Função para fechar o popup ao clicar no botão "Cancelar"
    cancelChangePassword.addEventListener('click', function () {
        passwordPopup.classList.add('hidden');
        popupOverlay.style.display = 'none';
    });

    // Função para fechar o popup ao clicar fora dele
    popupOverlay.addEventListener('click', function (event) {
        // Verifica se o clique foi fora do conteúdo do popup
        if (!passwordPopup.contains(event.target)) {
            passwordPopup.classList.add('hidden');
            popupOverlay.style.display = 'none';
        }
    });

    // Evita fechar o popup ao clicar dentro dele
    passwordPopup.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    // Validações do formulário de mudança de senha
    const changePasswordForm = document.getElementById('changePasswordForm');
    changePasswordForm.addEventListener('submit', function (event) {
        const oldPassword = document.getElementById('oldPassword').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value.trim();

        if (!oldPassword || !newPassword || !confirmPassword) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Por favor, preencha todos os campos!',
            });
            return;
        }

        if (newPassword !== confirmPassword) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'A nova senha e a confirmação não coincidem!',
            });
        }
    });
});