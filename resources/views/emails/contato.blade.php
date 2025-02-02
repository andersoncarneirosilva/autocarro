<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Mensagem de Contato</title>
</head>
<body>
    <h2>Nova Mensagem de Contato</h2>
    
    <p><strong>Nome:</strong> {{ $dados['nome'] }}</p>
    <p><strong>Email:</strong> {{ $dados['email'] }}</p>
    <p><strong>Mensagem:</strong></p>
    <p>{{ $dados['mensagem'] }}</p>
</body>
</html>
