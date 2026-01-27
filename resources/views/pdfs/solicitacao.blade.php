<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Solicitação ATPV-e</title>
    <style>
        /* Configurações da Folha A4 */
        @page {
            margin: 2cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Container do conteúdo vindo do CKEditor */
        .conteudo-pdf {
            width: 100%;
        }

        /* Estilização de elementos que o CKEditor gera */
        h1, h2, h3 { text-align: center; text-transform: uppercase; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table td, table th {
            border: 1px solid #000;
            padding: 8px;
        }

        /* Remove bordas de tabelas se o usuário não as definiu explicitamente */
        .table-no-border td, .table-no-border th {
            border: none !important;
        }

        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .text-right { text-align: right; }
        
        /* Força a quebra de página se o usuário inserir um page-break no editor */
        .page-break {
            page-break-after: always;
        }

        /* Estilo para a linha de assinatura */
        .assinatura {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="conteudo-pdf">
        {!! $corpo !!}
    </div>
</body>
</html>