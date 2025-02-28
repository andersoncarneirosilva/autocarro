<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Resultado</title>
</head>
<body>
    <h1>Texto Extraído</h1>
    <p>{{ $extractedText }}</p>

    <a href="{{ route('ocr.index') }}">Voltar</a>
</body>
</html>
