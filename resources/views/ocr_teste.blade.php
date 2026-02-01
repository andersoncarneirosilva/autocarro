<!DOCTYPE html>
<html>
<head>
    <title>Alcecar - Teste OCR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Testar Leitura de CNH</h2>
        <form action="{{ route('ocr.processar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Selecione a Imagem da CNH (JPG/PNG)</label>
                <input type="file" name="arquivo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Processar Documento</button>
        </form>
    </div>
</body>
</html>