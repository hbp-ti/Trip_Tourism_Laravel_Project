<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload de Imagem</title>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        input[type="file"] {
            display: block;
            width: 100%;
            padding: 8px;
            margin: 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .result {
            margin-top: 20px;
            text-align: center;
        }

        .result img {
            max-width: 100%;
            height: auto;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload de Imagem</h1>
        <form id="imageUploadForm">
		@csrf
            <div class="form-group">
                <label for="image">Escolha uma imagem</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
            <button type="submit">Carregar Imagem</button>
        </form>

        <div class="result" id="result"></div>
    </div>

    <script>
        document.getElementById('imageUploadForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir o envio do formulário padrão

            let formData = new FormData();
            formData.append('image', document.getElementById('image').files[0]);

            // Enviar a imagem para a API usando Fetch
            fetch('/uploadImage', {
                method: 'POST',
                body: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = ''; // Limpar resultados anteriores

                if (data.success) {
                    resultDiv.innerHTML = `
                        <p class="success">Imagem carregada com sucesso!</p>
                        <p><strong>URL:</strong> <a href="${data.data.url}" target="_blank">${data.data.url}</a></p>
                        <p><strong>Nome original:</strong> ${data.data.original_name}</p>
                        <p><strong>Tamanho:</strong> ${data.data.size} bytes</p>
                        <p><strong>Mime Type:</strong> ${data.data.mime}</p>
                        <img src="${data.data.url}" alt="Imagem carregada">
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <p class="error">${data.message}</p>
                    `;
                }
            })
            .catch(error => {
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = `
                    <p class="error">Ocorreu um erro ao enviar a imagem.</p>
                `;
            });
        });
    </script>
</body>
</html>
