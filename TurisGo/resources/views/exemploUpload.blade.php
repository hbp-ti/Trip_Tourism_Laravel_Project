<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title>
</head>
<body>
    <h1>Upload de Imagem</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
        <p>Imagem carregada: <a href="{{ asset('storage/' . session('path')) }}" target="_blank">{{ session('path') }}</a></p>
        <img src="{{ asset('storage/' . session('path')) }}" alt="Imagem carregada" style="max-width: 300px;">
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('upload.handle') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Escolha uma imagem:</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Fazer Upload</button>
    </form>
</body>
</html>
