$(document).ready(function () {
    
    // Referências aos elementos
    const $languageToggle = $('#languageToggle');
    const $languageDropdown = $('#languageDropdown');
    const $profileCircle = $('.profile-circle');
    const $profileDropdown = $('.dropdown-menu');

    // Abrir/Fechar Language Dropdown
    $languageToggle.on('click', function (event) {
        event.preventDefault();
        // Fecha o dropdown de perfil, se estiver aberto
        $profileDropdown.hide();
        $languageDropdown.toggle();
    });

    // Abrir/Fechar Profile Dropdown
    $profileCircle.on('click', function (event) {
        event.stopPropagation();
        // Fecha o dropdown de linguagem, se estiver aberto
        $languageDropdown.hide();
        $profileDropdown.toggle();
    });

    // Fechar dropdowns ao clicar fora
    $(document).on('click', function (event) {
        if (
            !$languageDropdown.is(event.target) &&
            !$languageDropdown.has(event.target).length &&
            !$languageToggle.is(event.target)
        ) {
            $languageDropdown.hide();
        }
        if (
            !$profileDropdown.is(event.target) &&
            !$profileDropdown.has(event.target).length &&
            !$profileCircle.is(event.target)
        ) {
            $profileDropdown.hide();
        }
    });

    // Impedir propagação dentro dos dropdowns
    $languageDropdown.on('click', function (e) {
        e.stopPropagation();
    });
    $profileDropdown.on('click', function (e) {
        e.stopPropagation();
    });

    // 3. Notification Popup
    const notifications = [
        { id: 1, title: translate("New Tour Added"), description: translate("A new tour is available now!"), isRead: false },
        { id: 2, title: translate("Booking Confirmation"), description: translate("Your booking has been confirmed."), isRead: true }
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
    const notificationsUrl = appUrl + "/notifications";
    console.log(appUrl);
    const notificationUrl = appUrl + "/notification";
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
                                    <button class="toggle-button">▼</button>
                                    <span>${notification.title}</span>
                                    <span class="delete-icon trash-icon" data-id="${notification.id}">&#x1F5D1;</span> <!-- ícone de lixo -->
                                </div>
                                <div class="notification-content" style="display: none;">
                                    ${notification.description}
                                </div>
                            </div>
                        `;
                        $toastAccordion.append(notificationItem);
                    });

                    // Delegação de eventos para abrir/fechar notificações e atualizar status
                    $toastAccordion.on('click', '.notification-item', function (e) {
                        const $notificationItem = $(this);
                        const $content = $notificationItem.find('.notification-content');
                        const isHidden = $content.is(':hidden');
                        const notificationId = $notificationItem.data('id');

                        // Verifica se o clique não foi no ícone de exclusão
                        if (!$(e.target).hasClass('trash-icon')) {
                            // Alterna visibilidade do conteúdo
                            $content.toggle();
                            $(this).find('.toggle-button').text(isHidden ? '▲' : '▼'); // Alterar texto do botão, se necessário

                            // Atualizar status para "lida" se necessário
                            if (isHidden && $notificationItem.hasClass('notification-unread')) {
                                $.ajax({
                                    url: `${notificationsUrl}/${notificationId}/mark-as-read`,
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function () {
                                        $notificationItem.removeClass('notification-unread').addClass('notification-read');
                                    },
                                    error: function () {
                                        console.error('Erro ao marcar a notificação como lida');
                                    }
                                });
                            }
                        }
                    });

                    // Delegação de eventos para excluir uma notificação individual
                    $toastAccordion.on('click', '.delete-icon', function (e) {
                        e.stopPropagation(); // Impede que o clique no ícone de lixo acione o evento no item pai

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
                    $toastAccordion.append("<div class='notification-item'>" + translate('Notification not found.') + "</div>");
                }
            },
            error: function () {
                $toastAccordion.append("<div class='notification-item'>" + translate('Failed to get notifications.') + "</div>");
            }
        });
    }


    // Chama a função para carregar as notificações
    loadNotifications();

    // Evento para excluir todas as notificações ao clicar no ícone de lixo no cabeçalho
    $('#trash-icon').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: `${notificationUrl}/delete-all`,
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
