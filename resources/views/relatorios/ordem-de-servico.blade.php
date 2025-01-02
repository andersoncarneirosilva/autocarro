<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço</title>
    <style>
        table {
            font-family:Arial, Helvetica, sans-serif; 
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header-table {
            margin-bottom: 20px;
            
        }
        
    </style>
</head>
<body>

    <table style="border: 1px solid black; margin-bottom: 10px;">
        <tr>
            <td style="font-size: 12px;"><img src="images/relatorio/logo-top.png" alt="Logo" width="100px"><br>
            proconline.com.br</td>
            <td style="font-size: 12px;">
                Nome da Empresa<br>
                Email: vendas@teste.com.br<br>
                Whatsapp: (51)99999.9999
            </td>
            <td style=" text-align: right;">
                <strong>OS: {{ $ordemServico->id }}</strong><br>
                <p style="font-size: 12px;">Data: {{ Carbon\Carbon::parse($ordemServico->created_at)->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; border-botton: none;">
        <tr>
            <th colspan="5" style="text-align: center; background-color:#d6d6d6; font-size: 12px; line-height: 10px; ">
                <strong>DADOS DO CLIENTE</strong>
            </th>
        </tr>
    </table>
    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; border-top: none; border-bottom:none;">
        <tr style="height: 13px;">
            <td style="padding: 2px; border: 1px solid black; border-bottom:none; border-top:none;">
                <strong style="font-size:12px;">NOME</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->nome }}</p>
            </td>
            <td style="padding: 2px;">
                <strong style="font-size:12px;">CPF</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->cpf }}</p>
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; border-top:none; border-bottom:none;">
        <tr>
            <td style="padding: 2px; border: 1px solid black; border-bottom:none;">
                <strong style="font-size:12px;">ENDEREÇO</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->endereco }}, {{ $ordemServico->cliente->numero }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black; border-bottom:none;">
                <strong style="font-size:12px;">BAIRRO</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->bairro }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black; border-bottom:none;">
                <strong style="font-size:12px;">CEP</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->cep }}</p>
            </td>
        </tr>
    </table>


    <table style="border-collapse: collapse; width: 100%; margin-bottom: 10px; border: 1px solid black; border-top:none;  border-bottom:none;">
        <tr style="height: 13px;">
            <td style="padding: 2px; border: 1px solid black;">
                <strong style="font-size:12px;">MUNICÍPIO</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->cidade }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black;">
                <strong style="font-size:12px;">UF</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->estado }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black;">
                <strong style="font-size:12px;">FONE</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $ordemServico->cliente->fone }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black;">
                <strong style="font-size:12px;">DATA CADASTRO</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ Carbon\Carbon::parse($ordemServico->created_at)->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>
    
    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; border-botton: none;">
        <tr>
            <th colspan="5" style="text-align: center; background-color:#d6d6d6; font-size: 12px; line-height: 10px; ">
                <strong>INFORMAÇÕES DO VEÍCULO</strong>
            </th>
        </tr>
    </table>

    <table style="border-collapse: collapse; margin-bottom: 10px; width: 100%; border: 1px solid black; border-top:none; border-bottom:none;">
        <tr>
            <td style="padding: 2px; border: 1px solid black; border-bottom:none; border-top:none;">
                <strong style="font-size:12px;">PLACA</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $veiculo->documento->placa }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black; border-top:none;">
                <strong style="font-size:12px;">MARCA</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $veiculo->documento->marca }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black; border-bottom:none; border-top:none;">
                <strong style="font-size:12px;">ANO/MODELO</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $veiculo->documento->ano }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 2px; border: 1px solid black;">
                <strong style="font-size:12px;">PROPRIETÁRIO</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $veiculo->documento->nome }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black; border-top:none;">
                <strong style="font-size:12px;">COR</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $veiculo->documento->cor }}</p>
            </td>
            <td style="padding: 2px; border: 1px solid black;">
                <strong style="font-size:12px;">CIDADE</strong>
                <p style="font-size:12px; margin: 0; line-height: 10px;">{{ $veiculo->documento->cidade }}</p>
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
        <thead>
            <tr>
                <th style="width: 55%; background-color: #d6d6d6; font-size: 12px; line-height: 12px; padding: 5px;">
                    <strong>TIPO DE SERVIÇO</strong>
                </th>
                <th style="width: 15%; text-align: right; background-color: #d6d6d6; font-size: 12px; line-height: 12px; padding: 5px;">
                    <strong>VALOR SERVIÇO</strong>
                </th>
                <th style="width: 15%;text-align: right; background-color: #d6d6d6; font-size: 12px; line-height: 12px; padding: 5px;">
                    <strong>TAXAS</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicos as $servico)
                <tr style="height: 13px; border: 1px solid black; border-bottom: none; border-top: none;">
                    <td style="padding: 2px;">
                        <p style="font-size: 14px; margin: 0; border-left: none; line-height: 14px;">{{ $servico['nome_servico'] }}</p>
                    </td>
                    <td style="padding: 2px; text-align: right;">
                        <p style="font-size: 14px; margin: 0; line-height: 14px;">
                            R$ {{ number_format($servico['valor_servico'], 2, ',', '.') }}
                        </p>
                    </td>
                    <td style="padding: 2px; text-align: right;">
                        <p style="font-size: 14px; margin: 0; line-height: 14px;">
                            R$ {{ number_format($servico['taxa_servico'], 2, ',', '.') }}
                        </p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; border-top: none; margin-bottom: 10px;">
        <tr>
            <td style="width: 100%; text-align: right; background-color: #d6d6d6; font-size: 14px; line-height: 18px; padding: 5px;">
                <strong>VALOR TOTAL: </strong>R$ {{ number_format($ordemServico->valor_total, 2, ',', '.') }}
            </td>
        </tr>
    </table>
    

    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; margin-bottom: 10px;">
        <thead>
            <tr>
                <th style="width: 55%; background-color: #d6d6d6; font-size: 14px; line-height: 14px; padding: 5px; ">
                    <strong>DESCRIÇÃO DO SERVIÇO</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="height: 13px;  border: 1px solid black;">
                <td style="padding: 2px;">
                    <p style="font-size: 14px; margin: 0; border-left: none; line-height: 14px;">{{ $ordemServico->descricao }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; margin-bottom: 10px;">
        <thead>
            <tr>
                <th style="width: 55%; background-color: #d6d6d6; font-size: 12px; line-height: 10px; padding: 5px; ">
                    <strong>INFORMAÇÕES DE PAGAMENTO</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="height: 13px;  border: 1px solid black;">
                <td style="padding: 2px;">
                    <p style="font-size: 14px; margin: 0; border-left: none; line-height: 14px;">{{ $ordemServico->forma_pagamento }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="border-collapse: collapse; width: 100%; border: 1px solid black; margin-top: 20px;">
        <thead>
            <tr>
                <th style="width: 50%; background-color: #d6d6d6; font-size: 12px; padding: 10px; text-align: center;">
                    <strong>ASSINATURA DO CLIENTE</strong>
                </th>
                <th style="width: 50%; background-color: #d6d6d6; font-size: 12px; padding: 10px; text-align: center;">
                    <strong>ASSINATURA DA EMPRESA</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="height: 50px;">
                <td style="text-align: center; border-top: 1px solid black; padding-top: 30px;">
                    ____________________________
                </td>
                <td style="text-align: center; border-top: 1px solid black; padding-top: 30px;">
                    ____________________________
                </td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 10px; padding-top: 5px;">
                    <em>Assinatura e Nome Legível</em>
                </td>
                <td style="text-align: center; font-size: 10px; padding-top: 5px;">
                    <em>Assinatura e Nome Legível</em>
                </td>
            </tr>
        </tbody>
    </table>

    

</body>
</html>
