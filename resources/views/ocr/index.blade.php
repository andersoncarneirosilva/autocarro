<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Upload</title>
</head>
<body>
    <h1>Upload de Imagem para OCR</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ocr.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Escolha uma imagem:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
