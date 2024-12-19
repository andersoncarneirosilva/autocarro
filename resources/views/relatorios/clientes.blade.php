<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            width: 100%;
            height: 100%;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #363d4b;
        }
        .header p {
            font-size: 14px;
            color: #777;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table thead {
            background-color: #363d4b;
            color: white;
        }
        table th {
            text-align: left;
            padding: 12px;
            font-size: 12px; /* Tamanho da fonte para os cabeçalhos */
        }
        table td {
            text-align: left;
            padding: 10px;
            font-size: 14px; /* Tamanho da fonte para as células de dados */
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="images/logo-login-saes.png" alt="Logo" style="max-width: 100px;">

            <h1>Relatório de Clientes</h1>
            <p>Gerado em: {{ date('d/m/Y') }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Fone</th>
                    <th>Email</th>
                    <th>CEP</th>
                    <th>Endereço</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cpf }}</td>
                    <td>{{ $cliente->fone }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->cep }}</td>
                    <td>{{ $cliente->endereco }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p>Relatório gerado automaticamente. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
