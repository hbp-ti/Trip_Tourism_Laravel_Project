document.addEventListener("DOMContentLoaded", () => {
    const addHotelSection = document.getElementById("add-hotel");
    const addTourSection = document.getElementById("add-tour");
    const deleteItem = document.getElementById("delete-item");
    const hotelsSection = document.getElementById("hotels-section");
    const toursSection = document.getElementById("tours-section");
    const hotelsPagination = document.getElementById("hotels-pagination");
    const toursPagination = document.getElementById("tours-pagination");
    const listAdminsSection = document.getElementById("list-admins");
    const promoteButton = document.querySelectorAll("[id^='promote-button']");

    const addHotelLink = document.getElementById("add-hotel-link");
    const addTourLink = document.getElementById("add-tour-link");
    const deleteItemLink = document.getElementById("delete-item-link");
    const adminLink = document.getElementById("admin-link");

    const addHotelForm = document.querySelector("#add-hotel form");
    const fileInput = addHotelForm.querySelector('input[type="file"]');
    const submitButton = addHotelForm.querySelector("button[type='submit']");

    const addTourForm = document.querySelector("#add-tour form");
    const tourFileInput = addTourForm.querySelector('input[type="file"]');


    // Função para capturar os dados do formulário e enviar ao servidor
    addHotelForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Impede o envio normal do formulário

        const formData = new FormData(addHotelForm); // Cria um novo FormData com os dados do formulário

        // Se houver arquivos no input de imagens, adiciona-os ao FormData
        if (fileInput.files.length > 0) {
            Array.from(fileInput.files).forEach(file => {
                formData.append("hotel_images[]", file); // Adiciona os arquivos ao FormData
            });
        }

        // Envia os dados para o controlador usando fetch
        fetch(addHotelForm.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
        })
        .then(response => {
            console.log(response); // Verifica a resposta para depuração
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire('Success!', 'Hotel added successfully!', 'success');
                addHotelForm.reset();
            } else {
                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
        });        
    });

    addTourForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Impede o envio padrão do formulário
    
        const formData = new FormData(addTourForm); // Captura os dados do formulário
    
        // Adiciona arquivos ao FormData, caso existam
        if (tourFileInput.files.length > 0) {
            Array.from(tourFileInput.files).forEach(file => {
                formData.append("tour_images[]", file); // Adiciona os arquivos ao FormData
            });
        }
    
        // Imprime os dados enviados para o controlador
        console.log("Dados enviados para o controlador:");
        for (let pair of formData.entries()) {
            console.log(pair[0], pair[1]);
        }
    
        // Envia os dados ao controlador
        fetch(addTourForm.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Success!', 'Tour added successfully!', 'success');
                addTourForm.reset();
            } else {
                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
        });
    });       


    // Evento de paginação para hotéis
    hotelsPagination.addEventListener("click", (e) => {
        if (e.target.tagName === "A") {
            e.preventDefault();
            const url = e.target.getAttribute("href");
            loadHotelsPage(url);
        }
    });

    // Evento de paginação para tours
    toursPagination.addEventListener("click", (e) => {
        if (e.target.tagName === "A") {
            e.preventDefault();
            const url = e.target.getAttribute("href");
            loadToursPage(url);
        }
    });

    // Função para carregar uma nova página de hotéis
    function loadHotelsPage(url) {
        fetch(url)
            .then((response) => response.text())
            .then((data) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                const newHotelsTableBody = doc.querySelector("#hotels-table-body");
                const newHotelsPagination = doc.querySelector("#hotels-pagination");

                document.getElementById("hotels-table-body").innerHTML = newHotelsTableBody.innerHTML;
                document.getElementById("hotels-pagination").innerHTML = newHotelsPagination.innerHTML;

                attachDeleteEvents("hotels-table-body"); // Re-anexar eventos de delete
            })
            .catch((error) => console.error("Error loading hotels page:", error));
    }

    // Função para carregar uma nova página de tours
    function loadToursPage(url) {
        fetch(url)
            .then((response) => response.text())
            .then((data) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                const newToursTableBody = doc.querySelector("#tours-table-body");
                const newToursPagination = doc.querySelector("#tours-pagination");

                document.getElementById("tours-table-body").innerHTML = newToursTableBody.innerHTML;
                document.getElementById("tours-pagination").innerHTML = newToursPagination.innerHTML;

                attachDeleteEvents("tours-table-body"); // Re-anexar eventos de delete
            })
            .catch((error) => console.error("Error loading tours page:", error));
    }

    // Função para deletar itens
    function attachDeleteEvents(tableBodyId) {
        const tableBody = document.getElementById(tableBodyId);
        if (tableBody) {
            const deleteButtons = tableBody.querySelectorAll(".delete-button");

            deleteButtons.forEach((button) => {
                button.addEventListener("click", (e) => {
                    e.preventDefault();
                    const itemId = button.getAttribute("data-id");

                    if (confirm("Tem certeza que deseja deletar este item?")) {
                        deleteItemFromServer(itemId).then(() => {
                            button.closest("tr").remove(); // Remove a linha da tabela
                        }).catch((error) => {
                            console.error("Erro ao deletar item:", error);
                            alert("Não foi possível deletar o item.");
                        });
                    }
                });
            });
        }
    }

    // Função para enviar o pedido de delete ao servidor
    function deleteItemFromServer(itemId) {
        return fetch(`/admin/removeItem/${itemId}`, {
            method: "POST", // Post porque a rota Laravel está usando POST
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
        }).then((response) => {
            if (!response.ok) {
                throw new Error("Erro na exclusão do item.");
            }
        });
    }

    promoteButton.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault(); // Impede o envio do formulário imediatamente
            const userId = button.id.replace('promote-button-', ''); // Obtém o ID do usuário a partir do ID do botão
            const form = document.getElementById(`promote-form-${userId}`); // Seleciona o formulário correspondente
            
            // Exibe o SweetAlert de confirmação
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to promote this user to Admin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, promote!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se o usuário confirmar, submete o formulário
                    form.submit();
                    
                    // Exibe o SweetAlert de sucesso
                    Swal.fire(
                        'Success!',
                        'User has been promoted to Admin.',
                        'success'
                    );
                }
            });
        });
    });


    // Evento para mostrar a lista de Admins e Utilizadores
    adminLink.addEventListener("click", (e) => {
        e.preventDefault();
        listAdminsSection.style.display = "block";
        addHotelSection.style.display = "none";
        addTourSection.style.display = "none";
        deleteItem.style.display = "none";
        hotelsSection.style.display = "none";
        toursSection.style.display = "none";
    });

    // Evento para mostrar "Add Hotel"
    addHotelLink.addEventListener("click", (e) => {
        e.preventDefault();
        addHotelSection.style.display = "block";
        addTourSection.style.display = "none";
        deleteItem.style.display = "none";
        hotelsSection.style.display = "none";
        toursSection.style.display = "none";
        listAdminsSection.style.display = "none";
    });

    // Evento para mostrar "Add Tour"
    addTourLink.addEventListener("click", (e) => {
        e.preventDefault();
        addHotelSection.style.display = "none";
        addTourSection.style.display = "block";
        deleteItem.style.display = "none";
        hotelsSection.style.display = "none";
        toursSection.style.display = "none";
        listAdminsSection.style.display = "none";
    });

    // Evento para mostrar "Delete Item"
    deleteItemLink.addEventListener("click", (e) => {
        e.preventDefault();
        addHotelSection.style.display = "none";
        addTourSection.style.display = "none";
        deleteItem.style.display = "block";
        hotelsSection.style.display = "block";
        toursSection.style.display = "block";
        listAdminsSection.style.display = "none";
    });

    // Anexar eventos de delete na inicialização
    attachDeleteEvents("hotels-table-body");
    attachDeleteEvents("tours-table-body");
});