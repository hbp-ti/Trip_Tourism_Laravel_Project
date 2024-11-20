<?php

namespace App\Helpers;

class PopupHelper
{
    /**
     * Função para gerar o código do SweetAlert com os parâmetros fornecidos.
     * 
     * @param string $title - Título do popup
     * @param string $text - Texto do popup
     * @param string $icon - Tipo de ícone (success, error, info, warning, etc.)
     * @param string $confirmButtonText - Texto do botão de confirmação
     * @param bool $showCancelButton - Se o botão de cancelamento será mostrado
     * @param string $cancelButtonText - Texto do botão de cancelamento
     * @param int $timer - Tempo em milissegundos para o popup fechar automaticamente (0 para não fechar)
     * 
     * @return string - Código HTML/JavaScript para o popup SweetAlert
     */
    public static function showPopup($title = 'Title', $text = 'Text', $icon = 'info', $confirmButtonText = 'OK', $showCancelButton = false, $cancelButtonText = 'Cancel', $timer = 0)
    {
        // Escapando as variáveis PHP para garantir a sintaxe correta em JavaScript
        $title = json_encode($title);
        $text = json_encode($text);
        $confirmButtonText = json_encode($confirmButtonText);
        $cancelButtonText = json_encode($cancelButtonText);

        // Definindo as cores dos botões de acordo com o tipo de popup
        $confirmButtonColor = '#28a745';
        $cancelButtonColor = '#dc3545';
        // Gerando o código do SweetAlert
        $swal = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: $title,
                    text: $text,
                    icon: '$icon',
                    showCancelButton: " . ($showCancelButton ? 'true' : 'false') . ",
                    confirmButtonText: $confirmButtonText,
                    cancelButtonText: $cancelButtonText,
                    timer: $timer,
                    timerProgressBar: " . ($timer > 0 ? 'true' : 'false') . ",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'custom-confirm-btn',
                        cancelButton: 'custom-cancel-btn'
                    },
                    willOpen: () => {
                        // Altera a cor do botão de confirmação
                        document.querySelector('.custom-confirm-btn').style.backgroundColor = '$confirmButtonColor';
                        document.querySelector('.custom-confirm-btn').style.borderColor = '$confirmButtonColor';
                        
                        // Altera a cor do botão de cancelamento (se existir)
                        if (document.querySelector('.custom-cancel-btn')) {
                            document.querySelector('.custom-cancel-btn').style.backgroundColor = '$cancelButtonColor';
                            document.querySelector('.custom-cancel-btn').style.borderColor = '$cancelButtonColor';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lógica para quando o botão de confirmação for clicado
                    } else if (result.isDismissed) {
                        // Se o botão de cancelamento for clicado
                    }
                });
            });
        </script>";

        return $swal;
    }
}
