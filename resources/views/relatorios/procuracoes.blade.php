<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Relatório de Procurações</title>
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
            max-width: 100px;
            height: auto;
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
            font-size: 12px;
        }

        table td {
            text-align: left;
            padding: 10px;
            font-size: 14px;
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
        .site{
            background: none
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
                        <h1>Relatório de Procurações</h1>
                    </td>
                    <td class="date">
                        <p>Gerado em: {{ date('d/m/Y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="site">
                        www.proconline.com.br
                    </td>
                </tr>
            </table>
        </div>      
        
        <table>
            <thead>
                <tr>
                    <th>Proprietário</th>
                    <th>CPF</th>
                    <th>Veículo</th>
                    <th>Placa</th>
                    <th>Ano/Modelo</th>
                    <th>Cor</th>
                    <th>Gerado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($procs as $proc)
                <tr>
                    <td>{{ $proc->nome }}</td>
                    <td>{{ $proc->cpf }}</td>
                    <td>{{ $proc->marca }}</td>
                    <td>{{ $proc->placa }}</td>
                    <td>{{ $proc->ano }}</td>
                    <td>{{ $proc->cor }}</td>
                    <td>{{ Carbon\Carbon::parse($proc->created_at)->format('d/m/Y') }}</td>
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
