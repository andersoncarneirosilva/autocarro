<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Ordens de Serviço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            width: 100%;
            margin-bottom: 20px;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .header th, .header td {
            padding: 0;
            vertical-align: middle;
        }

        .logo img {
            max-width: 100px; /* Limita o tamanho do logo */
            height: auto; /* Garante que a imagem preserve a proporção */
        }

        .header-title {
            text-align: center;
            font-size: 12px;
            color: #363d4b;
        }

        .date {
            text-align: right;
            color: #777;
        }

        .date p {
            font-size: 14px;
            margin: 0;
        }

        /* Tabela */
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
            background: none;
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
            <table>
                <tr>
                    <td class="logo">
                        <img src="images/relatorio/logo-top.png" alt="Logo">
                    </td>
                    <td class="header-title">
                        <h1>Relatório de Ordens de Serviço</h1>
                    </td>
                    <td class="date">
                        <p>Gerado em: {{ date('d/m/Y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        www.proconline.com.br
                    </td>
                </tr>
            </table>
        </div>      
        
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Tipo de Serviço</th>
                    <th>Serviço</th>
                    <th>Cadastrado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $cli)
                <tr>
                    <td>{{ $cli->id }}</td>
                    <td>{{ $cli->cliente->nome }}</td>
                    <td>{{ $cli->tipo_servico }}</td>
                    <td>R$ {{ number_format($cli->valor_total, 2, ',', '.') }}</td>
                    <td>{{ Carbon\Carbon::parse($cli->created_at)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Relatório gerado automaticamente.</p>
        </div>
    </div>
</body>
</html>
