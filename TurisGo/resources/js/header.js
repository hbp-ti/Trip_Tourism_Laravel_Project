$(document).ready(function () {
    // 1. Language Dropdown
    const $languageToggle = $('#languageToggle');
    const $languageDropdown = $('#languageDropdown');

    $languageToggle.on('click', function (event) {
        event.preventDefault();
        $languageDropdown.toggle();
    });

    $(document).on('click', function (event) {
        if (
            !$languageDropdown.is(event.target) &&
            !$languageDropdown.has(event.target).length &&
            !$languageToggle.is(event.target) &&
            !$languageToggle.has(event.target).length
        ) {
            $languageDropdown.hide();
        }
    });

    // 2. Profile Dropdown
    $('.profile-circle').on('click', function (e) {
        e.stopPropagation();
        $('.dropdown-menu').toggle();
    });

    $(document).on('click', function () {
        $('.dropdown-menu').hide();
    });

    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });

    // 3. Notification Popup
    const notifications = [
        { id: 1, title: "New Tour Added", description: "A new tour is available now!", isRead: false },
        { id: 2, title: "Booking Confirmation", description: "Your booking has been confirmed.", isRead: true }
    ];

    const notificationButton = $('#notificationButton');
    const notificationPopup = $('#liveToast');
    const notificationContent = $('#accordionExample');

    notificationButton.on('click', function () {
        notificationPopup.toast('show');
        loadNotifications();
    });

    function loadNotifications() {
        notificationContent.html("");

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

    $(document).on('click', '.accordion-button', function () {
        const notificationId = $(this).closest('.accordion-item').data('id');
        const notification = notifications.find(n => n.id === notificationId);
        if (notification && !notification.isRead) {
            notification.isRead = true;
            loadNotifications();
        }
    });

    $('#trash-icon').on('click', function () {
        notifications.length = 0;
        loadNotifications();
    });

    $('.close-toast').on('click', function () {
        notificationPopup.toast('hide');
    });

    document.getElementById('liveToast').classList.add('show');
    document.getElementById('liveToast').classList.remove('show');
});

// 4. Sticky Navbar and Language Image Swap
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

// 5. Navbar Active Links
document.querySelectorAll('.nav-links li a').forEach(link => {
    link.addEventListener('click', function () {
        document.querySelectorAll('.nav-links li a').forEach(link => {
            link.classList.remove('active');
        });
        this.classList.add('active');
    });
});

// 6. Toggle Notifications Content
document.querySelectorAll('.toggle-button').forEach(button => {
    button.addEventListener('click', function () {
        const content = this.parentElement.nextElementSibling;
        const isVisible = content.style.display === 'block';

        this.textContent = isVisible ? '▼' : '▲';
        content.style.display = isVisible ? 'none' : 'block';
    });
});

$(document).ready(function () {
    const notificationsUrl = "/notifications";
    const $toastAccordion = $('#toast-accordion');

    // Função para carregar as notificações via AJAX
    function loadNotifications() {
        $.ajax({
            url: notificationsUrl,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $toastAccordion.empty();

                if (data.success && data.notifications.length > 0) {
                    $.each(data.notifications, function (index, notification) {
                        const notificationClass = notification.is_read ? "notification-read" : "notification-unread";

                        // Adicionando o ícone de lixo para excluir cada notificação
                        const notificationItem = `
                            <div class="notification-item ${notificationClass}" data-id="${notification.id}">
                                <div class="notification-header">
                                    <span>${notification.title}</span>
                                    <button class="toggle-button">▼</button>
                                    <span class="delete-icon trash-icon" data-id="${notification.id}">&#x1F5D1;</span> <!-- ícone de lixo -->
                                </div>
                                <div class="notification-content" style="display: none;">
                                    ${notification.description}
                                </div>
                            </div>
                        `;
                        $toastAccordion.append(notificationItem);
                    });

                    // Evento de clique para abrir/fechar notificações e atualizar status
                    $('.toggle-button').on('click', function () {
                        const $notificationItem = $(this).closest('.notification-item');
                        const $content = $notificationItem.find('.notification-content');
                        const isHidden = $content.is(':hidden');
                        const notificationId = $notificationItem.data('id');

                        // Alternar visibilidade do conteúdo
                        $content.toggle();
                        $(this).text(isHidden ? '▲' : '▼');

                        // Atualizar status para "lida" se necessário
                        if (isHidden && $notificationItem.hasClass('notification-unread')) {
                            $.ajax({
                                url: `${notificationsUrl}/${notificationId}/mark-as-read`,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function () {
                                    // Alterar classe para indicar que foi lida
                                    $notificationItem.removeClass('notification-unread').addClass('notification-read');
                                },
                                error: function () {
                                    console.error('Erro ao marcar a notificação como lida');
                                }
                            });
                        }
                    });

                    // Evento de clique para excluir uma notificação individual
                    $('.delete-icon').on('click', function () {
                        const notificationId = $(this).data('id');
                        const $notificationItem = $(this).closest('.notification-item');

                        $.ajax({
                            url: `${notificationsUrl}/${notificationId}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function () {
                                // Remover a notificação da interface
                                $notificationItem.remove();
                            },
                            error: function () {
                                console.error('Erro ao excluir a notificação');
                            }
                        });
                    });
                } else {
                    $toastAccordion.append('<div class="notification-item">Nenhuma notificação encontrada.</div>');
                }
            },
            error: function () {
                $toastAccordion.append('<div class="notification-item">Erro ao carregar notificações.</div>');
            }
        });
    }

    // Chama a função para carregar as notificações
    loadNotifications();

    // Evento para excluir todas as notificações ao clicar no ícone de lixo no cabeçalho
    $('#trash-icon').on('click', function () {
        $.ajax({
            url: `${notificationsUrl}/delete-all`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $toastAccordion.empty(); // Limpar as notificações da interface
                $toastAccordion.append('<div class="notification-item">Todas as notificações foram excluídas.</div>');
            },
            error: function () {
                console.error('Erro ao excluir todas as notificações');
            }
        });
    });
});



