<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* Configurações da Folha A4 */
        @page { 
            size: A4;
            /* Margens padrão de documentos jurídicos: 
               Superior e Esquerda maiores para grampeamento/furo */
            margin: 1.0cm 1.5cm 1.0cm 1.5cm; 
        }

        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11pt; /* 11pt ou 12pt é o ideal para leitura */
            line-height: 1.6; /* Espaçamento entre linhas levemente maior */
            text-align: justify;
            color: #000;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        hr {
        border: 0;
        border-top: 0.5pt solid #000 !important; /* Espessura técnica de linha jurídica */
        height: 0;
        margin: 20px auto;
        width: 100%; /* Respeita as margens de 1.5cm do @page */
        opacity: 1;
    }

    /* Caso você use a técnica do parágrafo com borda no editor */
    .content p[style*="border-top"], 
    .content p[style*="border-bottom"] {
        border-color: #000 !important;
        border-width: 0.5pt !important;
        border-style: solid !important;
        display: block;
        width: 100% !important;
    }

    /* Reduz o espaço excessivo entre os dados dos Outorgados */
    .content p {
        margin-bottom: 8pt; /* Diminuído de 12pt para economizar espaço */
    }

        /* Formatação de parágrafos */
        p { 
            margin-bottom: 12pt; 
            margin-top: 0; 
            orphans: 3; /* Evita que uma linha fique sozinha no fim da página */
            widows: 3;  /* Evita que uma linha fique sozinha no topo da página */
        }

        strong { font-weight: bold; }

        /* Ajuste para que tabelas e imagens não estourem a largura */
        table, img {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="content">
        {!! $corpo !!}
    </div>
</body>
</html>