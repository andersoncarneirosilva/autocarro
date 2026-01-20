<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; line-height: 1.5; font-size: 12pt; }
        .titulo { text-align: center; font-weight: bold; font-size: 16pt; margin-bottom: 30px; }
        .secao { font-weight: bold; margin-top: 20px; text-transform: uppercase; }
        .texto { text-align: justify; margin-top: 10px; }
        .assinatura { margin-top: 50px; text-align: center; }
        .linha { border-top: 1px solid #000; width: 300px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="titulo">PROCURAÇÃO</div>

    <div class="secao">Outorgante:</div>
    <p><strong>{{ $cliente->nome }}</strong>, CPF/CNPJ: {{ $cliente->cpf_cnpj }}, residente em {{ $cliente->endereco }}.</p>

    <div class="secao">Outorgados:</div>
    @foreach($outorgados as $o)
        <p><strong>{{ $o->nome_outorgado }}</strong>, CPF: {{ $o->cpf_outorgado }}.</p>
    @endforeach

    <div class="secao">Poderes:</div>
    <div class="texto">{{ $configProc->texto_inicial }}</div>

    <div class="secao">Veículo:</div>
    <p>MARCA/MODELO: {{ $anuncio->marca }} | PLACA: {{ $anuncio->placa }} | CHASSI: {{ $anuncio->chassi }}</p>

    <div class="assinatura">
        <p>{{ $configProc->cidade }}, {{ now()->translatedFormat('d \d\e F \d\e Y') }}</p>
        <br><br>
        <div class="linha"></div>
        <p><strong>{{ $cliente->nome }}</strong></p>
    </div>
</body>
</html>