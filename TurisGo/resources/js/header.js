$(document).ready(function () {
    const $languageToggle = $('#languageToggle');
    const $languageDropdown = $('#languageDropdown');

    $languageToggle.on('click', function (event) {
        event.preventDefault();
        $languageDropdown.toggle();
    });

    // Fecha o dropdown se clicar fora dele
    $(document).on('click', function (event) {
        if (!$languageDropdown.is(event.target) && !$languageDropdown.has(event.target).length &&
            !$languageToggle.is(event.target) && !$languageToggle.has(event.target).length) {
            $languageDropdown.hide();
        }
    });

    // Abrir e fechar o dropdown ao clicar no círculo
    $('.profile-circle').on('click', function (e) {
        e.stopPropagation(); // Evita fechar o dropdown ao clicar no círculo
        $('.dropdown-menu').toggle(); // Alterna entre mostrar e ocultar
    });

    // Fechar o dropdown ao clicar fora dele
    $(document).on('click', function () {
        $('.dropdown-menu').hide(); // Fecha o dropdown
    });

    // Evitar que o dropdown feche ao clicar dentro dele
    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation(); // Impede o fechamento ao clicar dentro do menu
    });
});

document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.navbar');
        const languageImg = document.querySelector(".language-img");

        if (window.scrollY > 50) {
            header.classList.add('navbar-fixed');
            languageImg.src = languageImg.src.replace("languageSelection1.png", "languageSelection2.png");
        } else {
            header.classList.remove('navbar-fixed');
            languageImg.src = languageImg.src.replace("languageSelection2.png", "languageSelection1.png");
        }
    });

});

document.querySelectorAll('.nav-links li a').forEach(link => {
    link.addEventListener('click', function () {
        // Remove a classe 'active' de todos os links
        document.querySelectorAll('.nav-links li a').forEach(link => {
            link.classList.remove('active');
        });

        // Adiciona a classe 'active' no link clicado
        this.classList.add('active');
    });
});

$(document).ready(function () {
    // Mock de notificações
    const notifications = [
        { id: 1, title: "New Tour Added", description: "A new tour is available now!", isRead: false },
        { id: 2, title: "Booking Confirmation", description: "Your booking has been confirmed.", isRead: true }
    ];

    const notificationButton = $('#notificationButton');
    const notificationPopup = $('#liveToast');
    const notificationContent = $('#accordionExample');

    // Exibe ou oculta o popup de notificações
    notificationButton.on('click', function () {
        notificationPopup.toast('show');
        loadNotifications();
    });

    // Carrega notificações dinamicamente
    function loadNotifications() {
        notificationContent.html(""); // Limpa o conteúdo anterior

        if (notifications.length === 0) {
            notificationContent.html("<p>No notifications</p>");
            return;
        }

        notifications.forEach(notification => {
            const notificationClass = notification.isRead ? "notification-read" : "notification-unread";
            notificationContent.append(`
                <div class="accordion-item ${notificationClass}" data-id="${notification.id}">
                    <h2 class="accordion-header" id="heading${notification.id}">
                        <button class="accordion-button ${notificationClass}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${notification.id}" aria-expanded="true" aria-controls="collapse${notification.id}">
                            ${notification.title}
                        </button>
                    </h2>
                    <div id="collapse${notification.id}" class="accordion-collapse collapse" aria-labelledby="heading${notification.id}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            ${notification.description}
                        </div>
                    </div>
                </div>
            `);
        });
    }

    // Marcar notificação como lida
    $(document).on('click', '.accordion-button', function () {
        const notificationId = $(this).closest('.accordion-item').data('id');
        const notification = notifications.find(n => n.id === notificationId);
        if (notification && !notification.isRead) {
            notification.isRead = true;
            loadNotifications();
        }
    });

    // Excluir todas as notificações
    $('#trash-icon').on('click', function () {
        notifications.length = 0;  // Limpa todas as notificações
        loadNotifications();
    });

    // Fechar o toast ao clicar no X
    $('.close-toast').on('click', function () {
        notificationPopup.toast('hide');
    });

    // Exibir o toast
    document.getElementById('liveToast').classList.add('show');
    document.getElementById('liveToast').classList.remove('show');
});
document.querySelectorAll('.toggle-button').forEach(button => {
    button.addEventListener('click', function () {
        const content = this.parentElement.nextElementSibling; // Seleciona o conteúdo
        const isVisible = content.style.display === 'block';
        
        // Alterna a seta
        this.textContent = isVisible ? '▼' : '▲';
        
        // Mostra ou oculta o conteúdo
        content.style.display = isVisible ? 'none' : 'block';
    });
});
