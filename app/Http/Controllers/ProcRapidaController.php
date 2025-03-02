<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Outorgado;
use App\Models\ProcRapida;
use App\Models\TextoInicio;
use App\Models\TextoPoder;
use App\Models\User;
use Carbon\Carbon;
use FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Smalot\PdfParser\Parser;

class ProcRapidaController extends Controller
{
    protected $model;

    public function __construct(ProcRapida $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request)
    {

        $title = 'Excluir!';
        $text = 'Deseja excluir esse documento?';
        confirmDelete($title, $text);
        $docs = ProcRapida::paginate(10);

        return view('procrapida.index', compact('docs'));
    }

    public function store(Request $request)
    {

        $cidades = Cidade::first();
        $outorgados = Outorgado::all();
        $textoFinal = TextoPoder::first();
        $textoInicial = TextoInicio::first();

        $dataAtual = Carbon::now();

        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        try {
            $validated = $request->validate([
                'arquivo_doc' => 'required|mimes:pdf|max:10240',
            ], [
                'arquivo_doc.mimes' => 'O arquivo deve ser um PDF.',
                'arquivo_doc.required' => 'O arquivo é obrigatório.',
                'arquivo_doc.max' => 'O arquivo não pode ultrapassar 10MB.',
            ]);
            // dd($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            alert()->error('Selecione o documento em pdf!');

            return redirect()->route('dashboard.index');
        }

        $arquivo = $request->file('arquivo_doc');

        $nomeOriginal = $arquivo->getClientOriginalName();

        $parser = new Parser;

        $pdf = $parser->parseFile($arquivo);

        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();

            $linhas = explode("\n", $textoPagina);

            if ($linhas[3] != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {
                alert()->error('Selecione um documento 2024.');

                return redirect()->route('procrapida.index');
            }

            $marca = $this->model->extrairMarca($textoPagina);
            $placa = $this->model->extrairPlaca($textoPagina);
            $chassi = $this->model->extrairChassi($textoPagina);
            $cor = $this->model->extrairCor($textoPagina);
            $anoModelo = $this->model->extrairAnoModelo($textoPagina);
            $renavam = $this->model->extrairRevanam($textoPagina);
            $nome = $this->model->extrairNome($textoPagina);
            $cpf = $this->model->extrairCpf($textoPagina);
            $cidade = $this->model->extrairCidade($textoPagina);
            $crv = $this->model->extrairCrv($textoPagina);
            $placaAnterior = $this->model->extrairPlacaAnterior($textoPagina);
            $categoria = $this->model->extrairCategoria($textoPagina);
            $motor = $this->model->extrairMotor($textoPagina);
            $combustivel = $this->model->extrairCombustivel($textoPagina);
            $infos = $this->model->extrairInfos($textoPagina);
        }

        $pdf = new FPDF;
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        $titulo = utf8_decode('PROCURAÇÃO');

        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');

        $larguraTitulo = $pdf->GetStringWidth($titulo);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 0, 'OUTORGANTE: '.strtoupper($nome), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, "CPF: $cpf", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode('ENDEREÇO: '.strtoupper($request->endereco)), 0, 0, 'L');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, '________________________________________________________________________________________', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Ln(8);

        foreach ($outorgados as $outorgado) {
            $pdf->Cell(0, 0, utf8_decode("OUTORGADO: {$outorgado->nome_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("CPF: {$outorgado->cpf_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: {$outorgado->end_outorgado}"), 0, 0, 'L');
            $pdf->Ln(10); // Espaço extra entre cada outorgado
        }

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, '________________________________________________________________________________________', 0, 0, 'L');

        $pdf->Ln(8);
        $margem_esquerda = 10; // Margem esquerda
        $margem_direita = 10;  // Margem direita

        // Texto a ser inserido no PDF
        $text1 = "$textoInicial->texto_inicio";

        // Remover quebras de linha manuais, caso existam
        $text1 = str_replace("\n", ' ', $text1);

        // Calcular a largura disponível para o text1o (considerando as margens)
        $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o text1o justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text1), 0, 'J');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 2, 'MARCA: '.strtoupper($marca), 0, 0, 'L');
        $pdf->Cell(0, 2, 'PLACA: '.strtoupper($placa), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, 'CHASSI: '.strtoupper($chassi), 0, 0, 'L');
        $pdf->Cell(0, 2, 'COR: '.strtoupper($cor), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, 'ANO/MODELO: '.strtoupper($anoModelo), 0, 0, 'L');
        $pdf->Cell(0, 2, 'RENAVAM: '.strtoupper($renavam), 0, 1, 'L');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);

        $text2 = "$textoFinal->texto_final";
        // dd($text2);
        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", ' ', $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$cidades->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita

        $pdf->Ln(5);
        $pdf->Cell(0, 10, '_________________________________________________', 0, 1, 'C');
        $pdf->Cell(0, 5, utf8_decode("$nome"), 0, 1, 'C');

        // Definir o nome do arquivo do PDF
        // $nomePDF = 'nome_extraido_' . time() . '.pdf';

        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de public
        $caminhoPDF = storage_path('app/public/procuracoes/'.'proc_'.strtoupper($placa).'.pdf');
        $urlPDF = asset('storage/procuracoes/'.'proc_'.strtoupper($placa).'.pdf');
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (! file_exists(storage_path('app/public/procuracoes'))) {
            mkdir(storage_path('app/public/procuracoes'), 0777, true); // Cria a pasta se ela não existir
        }

        // Salvar o PDF
        $pdf->Output('F', $caminhoPDF);

        $data = [
            'marca' => $marca,
            'placa' => $placa,
            'chassi' => $chassi,
            'cor' => $cor,
            'ano' => $anoModelo,
            'renavam' => $renavam,
            'nome' => $nome,
            'cpf' => $cpf,
            'endereco' => $request->endereco,
            'cidade' => $cidade,
            'crv' => $crv,
            'placaAnterior' => $placaAnterior,
            'categoria' => $categoria,
            'motor' => $motor,
            'combustivel' => $combustivel,
            'infos' => $infos,
            'arquivo_doc' => $urlPDF,
        ];

        if ($this->model->create($data)) {
            alert()->success('Procuração gerada com sucesso!');

            // Retornar os links para visualização e download
            $linkVisualizar = "<a href='$urlPDF' class='btn btn-success btn-sm' target='_blank'>Visualizar PDF</a>";
            $linkBaixar = "<a href='$urlPDF' class='btn btn-primary btn-sm' download>Baixar PDF</a>";

            return redirect()->route('dashboard.index')
                ->with('success', 'Procuração gerada com sucesso!')
                ->with('links', compact('linkVisualizar', 'linkBaixar'));
        }

    }

    public function gerarAtpve(Request $request)
    {
        $cidade = Cidade::first();
        $outorgados = Outorgado::first();
        $textoFinal = TextoPoder::first();
        $textoInicial = TextoInicio::first();
        $cidade = Cidade::first();

        $dataAtual = Carbon::now();

        $dataDia = $dataAtual->translatedFormat('d');
        $dataMes = $dataAtual->translatedFormat('m');
        $dataAno = $dataAtual->translatedFormat('Y');

        try {
            $validated = $request->validate([
                'arquivo_doc' => 'required|mimes:pdf|max:10240',
            ], [
                'arquivo_doc.mimes' => 'O arquivo deve ser um PDF.',
                'arquivo_doc.required' => 'O arquivo é obrigatório.',
                'arquivo_doc.max' => 'O arquivo não pode ultrapassar 10MB.',
            ]);
            // dd($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            alert()->error('Selecione o documento em pdf!');

            return redirect()->route('dashboard.index');
        }

        $arquivo = $request->file('arquivo_doc');

        $nomeOriginal = $arquivo->getClientOriginalName();

        $parser = new Parser;

        $pdf = $parser->parseFile($arquivo);

        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();

            $linhas = explode("\n", $textoPagina);

            if ($linhas[3] != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {
                alert()->error('Selecione um documento 2024.');

                return redirect()->route('dashboard.index');
            }

            $marca = $this->model->extrairMarca($textoPagina);
            $placa = $this->model->extrairPlaca($textoPagina);
            $chassi = $this->model->extrairChassi($textoPagina);
            $cor = $this->model->extrairCor($textoPagina);
            $anoModelo = $this->model->extrairAnoModelo($textoPagina);
            $renavam = $this->model->extrairRevanam($textoPagina);
            $nome = $this->model->extrairNome($textoPagina);
            $cpf = $this->model->extrairCpf($textoPagina);
            $cidade = $this->model->extrairCidade($textoPagina);
            $crv = $this->model->extrairCrv($textoPagina);
            $placaAnterior = $this->model->extrairPlacaAnterior($textoPagina);
            $categoria = $this->model->extrairCategoria($textoPagina);
            $motor = $this->model->extrairMotor($textoPagina);
            $combustivel = $this->model->extrairCombustivel($textoPagina);
            $infos = $this->model->extrairInfos($textoPagina);
        }

        // Criar o PDF com FPDF
        $pdf = new FPDF;
        $pdf->SetMargins(30, 30, 30);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);

        $titulo = utf8_decode('POP 2');
        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'ANEXO 2 - REQUERIMENTO DE PREENCHIMENTO DA ATPV-e', 0, 1, 'C');
        $pdf->Ln(10);

        // Corpo do documento
        $pdf->SetFont('Arial', '', 10);
        // $pdf->MultiCell(0, 8, "Eu, ");

        // Definir posição para o nome e sublinhar apenas a informação dinâmica
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Posição para o nome e sublinhado
        $pdf->Text($x, $y, 'Eu, ');
        $x += $pdf->GetStringWidth('Eu, '); // Ajusta o X para o nome

        // Reduz a distância entre "Eu," e o nome do outorgado
        $x += 0; // Ajuste fino para aproximar o nome de "Eu,"

        // Sublinha apenas o nome do outorgado
        $this->desenharSublinhado($pdf, $x, 60, $outorgados->nome_outorgado, 140); // Chama o método dentro do controlador
        $x += 140; // Ajuste após o nome sublinhado

        // Continua o texto após o nome
        $pdf->Text($x, $y, ', ');
        $pdf->Ln(10);

        // Agora começa uma nova linha para o "CPF/CNPJ"
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'CPF/CNPJ:');
        $x += $pdf->GetStringWidth('CPF/CNPJ:'); // Ajusta o X para o CPF/CNPJ

        // Sublinha apenas o CPF/CNPJ
        $this->desenharSublinhado($pdf, $x, 69, $outorgados->cpf_outorgado, 56); // Chama o método dentro do controlador para o CPF/CNPJ
        $x += 56; // Ajuste após o CPF/CNPJ sublinhado

        // Continua o texto após o CPF/CNPJ
        $pdf->Text($x, $y, ', requeiro ao DETRAN/RS, o preenchimento da');
        $pdf->Ln(10); // Faz a quebra de linha para a próxima parte do texto

        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'ATPV-e, relativo ao veículo Placa:'));
        $x += $pdf->GetStringWidth('ATPV-e, relativo ao veículo Placa:');

        // Sublinha a "Placa"
        $this->desenharSublinhado($pdf, 84, 78, $placa, 20); // Sublinha a "Placa"
        $x += 20; // Ajuste após a "Placa" sublinhada

        // Continua o texto após a "Placa"
        $pdf->Text($x, $y, '. Chassi:');
        $x += $pdf->GetStringWidth('. Chassi:'); // Ajuste para "Chassi"

        // Sublinha o "Chassi"
        $this->desenharSublinhado($pdf, $x, 78, $chassi, 57); // Sublinha o "Chassi"
        $x += 57; // Ajuste após o "Chassi" sublinhado

        $pdf->Ln(10); // Linha em branco após o texto

        // Linha com "Renavam {$renavam} Marca/Modelo {$marca}"
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'Renavam:');
        $x += $pdf->GetStringWidth('Renavam:'); // Ajuste para "Renavam"

        // Sublinha o "Renavam"
        $this->desenharSublinhado($pdf, $x, 87, $renavam, 54); // Sublinha o "Renavam"
        $x += 54; // Ajuste após o "Renavam" sublinhado

        // Continua o texto após "Renavam"
        $pdf->Text($x, $y, ' Marca/Modelo ');
        $x += $pdf->GetStringWidth(' Marca/Modelo '); // Ajuste para "Marca/Modelo"

        // Sublinha o "Marca/Modelo"
        $this->desenharSublinhado($pdf, $x, 87, $marca, 53); // Sublinha o "Marca/Modelo"
        $x += 53; // Ajuste após o "Marca/Modelo" sublinhado

        $pdf->Ln(10); // Linha em branco após o texto

        // Agora vai para a nova linha para "PROPRIETÁRIO VENDEDOR:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'PROPRIETÁRIO VENDEDOR:'));
        $x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', 'PROPRIETÁRIO VENDEDOR:'));  // Ajusta o X para "PROPRIETÁRIO VENDEDOR:"
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(7);

        // Posição do texto "e-mail: despachanteluis@hotmail.com"
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'e-mail: ');

        // Calcula a largura do texto do email
        $emailText = 'e-mail: ';
        $x += $pdf->GetStringWidth($emailText); // Atualiza a posição X após o texto

        // Sublinha o email
        $this->desenharSublinhado($pdf, 42, 103, 'fernandofantinel@hotmail.com', 80); // Sublinha apenas o email
        $x += 80; // Ajuste após o "Marca/Modelo" sublinhado

        $pdf->Ln(20); // Linha em branco após o texto

        // Agora vai para a nova linha para "IDENTIFICAÇÃO DO ADQUIRENTE"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'IDENTIFICAÇÃO DO ADQUIRENTE'));
        $x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', 'IDENTIFICAÇÃO DO ADQUIRENTE'));  // Ajusta o X para "IDENTIFICAÇÃO DO ADQUIRENTE"
        $pdf->SetFont('Arial', '', 10);
        // Linha em branco após o título
        $pdf->Ln(8);

        $pdf->Text($x = 30, $y = $pdf->GetY(), 'CPF/CNPJ:');
        $x += $pdf->GetStringWidth('CPF/CNPJ:'); // Ajuste para "CPF/CNPJ:"

        // Sublinha o CPF
        $this->desenharSublinhado($pdf, $x, 130, $cpf, 93); // Sublinha o CPF
        $x += 93; // Ajuste após o CPF sublinhado

        $pdf->Ln(10);

        $pdf->Text($x = 30, $y = $pdf->GetY(), 'Nome:');
        $x += $pdf->GetStringWidth('Nome:');

        $this->desenharSublinhado($pdf, 41, 139, $nome, 100);
        $x += 100;

        $pdf->Ln(10);

        $pdf->Text($x = 30, $y = $pdf->GetY(), 'e-mail: ');
        $x += $pdf->GetStringWidth('e-mail:'); // Ajuste para "CPF/CNPJ:"

        // Sublinha o CPF
        $this->desenharSublinhado($pdf, 41, 148, $request['email'], 100); // Sublinha o CPF
        $x += 100;

        $pdf->Ln(20); // Linha em branco após o CPF

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'ENDEREÇO DO ADQUIRENTE'));
        $x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', 'ENDEREÇO DO ADQUIRENTE'));
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(10); // Linha em branco após o CPF
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'CEP:');
        $x += $pdf->GetStringWidth('CEP:'); // Ajuste para "Renavam"

        // Sublinha o "Renavam"
        $this->desenharSublinhado($pdf, $x, 177, $request['cep'], 40); // Sublinha o "Renavam"
        $x += 40;

        $pdf->Text($x, $y, ' UF:');
        $x += $pdf->GetStringWidth(' UF:');

        $this->desenharSublinhado($pdf, $x, 177, $request['estado'], 40);
        $x += 40;

        $pdf->Text($x, $y, iconv('UTF-8', 'ISO-8859-1', ' MUNICÍPIO:'));
        $x += $pdf->GetStringWidth(' MUNICÍPIO:');

        $this->desenharSublinhado($pdf, 146, 177, $request['cidade'], 40);
        $x += 40;

        $pdf->Ln(10);

        // Posição inicial do texto
        $x = 30;
        $y = $pdf->GetY();
        $pdf->Text($x, $y, 'Logradouro:Rua/Av.');

        // Ajusta posição para o endereço e sublinha
        $x += $pdf->GetStringWidth('Logradouro:Rua/Av.');
        $endereco = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $request['endereco']);
        $this->desenharSublinhado($pdf, $x, 186, $endereco, 80);

        $x += 80;

        // Texto "N."
        $pdf->Text(142, $y, ' N.');
        $x += $pdf->GetStringWidth(' N.');

        // Ajusta para o número e sublinha
        $this->desenharSublinhado($pdf, 146, 186, $request['numero'], 40);
        $x += 100;

        $pdf->Ln(10); // Linha em branco após o texto

        // Posição inicial do texto
        $x = 30;
        $y = $pdf->GetY();
        $pdf->Text($x, $y, 'Complemento:');
        $x += $pdf->GetStringWidth('Complemento:');
        $this->desenharSublinhado($pdf, $x, 195, $request['complemento'], 40);
        $x += 40;

        // Texto "N."
        $pdf->Text($x, $y, ' Bairro:');
        $x += $pdf->GetStringWidth(' Bairro:');

        // Ajusta para o número e sublinha
        $this->desenharSublinhado($pdf, $x, 195, $request['bairro'], 40);
        $x += 100;

        $pdf->Ln(10); // Linha em branco após o texto

        $pdf->SetFont('Arial', 'B', 10);

        // Posição inicial do texto
        $x = 30;
        $y = $pdf->GetY();
        $pdf->Text($x, $y, 'Valor:');
        // Ajusta posição para o endereço e sublinha
        $x += $pdf->GetStringWidth('Valor:');
        $this->desenharSublinhado($pdf, $x, 204, 'R$ '.number_format($request['valor'], 2, ',', '.'), 40);
        $x += 40;

        $pdf->Ln(10);

        $pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1', 'Declaro que li, estou de acordo e sou responsável pelas informações acima.'), 0, 1, 'C');

        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        // Define a posição inicial
        $x = 30;
        $y = $pdf->GetY();

        // Exibe o texto fixo "Data"
        $pdf->SetFont('Arial', '', 10);
        $pdf->Text($x, $y, 'Data: ');

        // Ajusta a posição para o primeiro campo (dia)
        $x += $pdf->GetStringWidth('Data: '); // Move o cursor para a direita
        $this->desenharSublinhado($pdf, $x, 231, $dataDia, 8); // Campo do dia sublinhado
        $x += 8; // Ajusta após o sublinhado do dia

        // Adiciona o separador "/"
        $pdf->Text($x, $y, ' / ');
        $x += $pdf->GetStringWidth(' / '); // Move o cursor após o "/"

        // Sublinha o campo do mês
        $this->desenharSublinhado($pdf, $x, 231, $dataMes, 8); // Campo do mês sublinhado
        $x += 8; // Ajusta após o sublinhado do mês

        // Adiciona o separador "/"
        $pdf->Text($x, $y, ' / ');
        $x += $pdf->GetStringWidth(' / '); // Move o cursor após o "/"

        // Sublinha o campo do ano (20____)
        $this->desenharSublinhado($pdf, $x, 231, $dataAno, 10); // Campo do ano sublinhado
        $x += 15; // Ajusta após o sublinhado do ano

        $pdf->Ln(20); // Linha em branco após o texto

        $pdf->Cell(0, 8, '__________________________________________', 0, 1, 'C');
        $pdf->Cell(0, 8, 'Assinatura do vendedor/representante legal', 0, 1, 'C');

        // Salvar o PDF no servidor
        $filePath = storage_path('app/public/atpves/').'atpve_'.$placa.'.pdf';
        if (! file_exists(storage_path('app/public/atpves'))) {
            mkdir(storage_path('app/public/atpves'), 0777, true);
        }
        $pdf->Output('F', $filePath);

        // Retornar o link do PDF para download/visualização
        $fileUrl = asset('storage/atpves/'.basename($filePath));

        if ($filePath) {
            alert()->success('ATPVe gerada com sucesso!');

            // Retornar os links para visualização e download
            $linkVisualizar = "<a href='$fileUrl' class='btn btn-success btn-sm' target='_blank'>Visualizar PDF</a>";
            $linkBaixar = "<a href='$fileUrl' class='btn btn-primary btn-sm' download>Baixar PDF</a>";

            return redirect()->route('dashboard.index')
                ->with('success-atpve', 'ATPVe gerada com sucesso!')
                ->with('links', compact('linkVisualizar', 'linkBaixar'));
        }

        // return response()->json([
        //     'message' => 'PDF gerado com sucesso!',
        //     'file_url' => $fileUrl,
        // ]);
    }

    public function desenharSublinhado($pdf, $x, $y, $texto, $largura)
    {
        $pdf->SetXY($x, $y);
        $pdf->Cell($largura, 0, $texto, 0, 0, 'L');
        $pdf->Line($x, $y + 2, $x + $largura, $y + 2); // Linha sublinhada
    }

    public function destroy($id)
    {
        // Tenta localizar o registro no banco de dados
        if (! $doc = $this->model->find($id)) {
            return redirect()->route('procrapida.index');
        }

        // Extrai apenas o nome do arquivo da URL completa
        $nomeArquivo = basename($doc->arquivo_doc); // Retorna "DOC-2024-MARILENE.pdf"
        // dd($nomeArquivo); // Verifique se o nome está correto

        // Monta o caminho completo para o arquivo no servidor
        $arquivo = storage_path('app/public/veiculos/'.$nomeArquivo);

        // Verifica se o arquivo existe e o exclui
        if (file_exists($arquivo)) {
            unlink($arquivo);
        }

        // Exclui o registro no banco de dados
        if ($doc->delete()) {
            alert()->success('Documento excluído com sucesso!');
        }

        return redirect()->route('procrapida.index');
    }

    public function gerarProc($id, $doc, Request $request)
    {

        $outorgados = Outorgado::all();
        $cidade = Cidade::first();

        $config = TextoPoder::get()->first();
        // dd($config);
        if ($outorgados == null) {
            alert()->error('Por favor, configure a procuração!');

            return redirect()->route('procrapida.index');
        }
        if ($config == null) {
            alert()->error('Por favor, configure a procuração!');

            return redirect()->route('procrapida.index');
        }
        $dataAtual = Carbon::now();
        $dataFormatada = $dataAtual->translatedFormat('d-m-Y-H-i-s');

        // dd($dataFormatada);
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');
        // $endereco = $request->endereco;

        $documento = Documento::where('id', $doc)->first();
        // $doc_id = $documento->id;

        $cliente = Cliente::where('id', $id)->first();

        if ($cliente) {
            $endereco = $cliente->endereco;
        }

        $pdf = new FPDF;
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();  // Adicionar uma página ao PDF
        // $pdfFpdf->SetFont('Arial', 'B', 16);  // Definir a fonte (Arial, Negrito, tamanho 16)
        $pdf->SetFont('Arial', 'B', 14);

        $titulo = utf8_decode('PROCURAÇÃO');

        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');

        $larguraTitulo = $pdf->GetStringWidth($titulo);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 0, "OUTORGANTE: $documento->nome", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, "CPF: $documento->cpf", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode('ENDEREÇO: '.strtoupper($endereco)), 0, 0, 'L');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, '________________________________________________________________________________________', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Ln(8);

        foreach ($outorgados as $outorgado) {
            // Adicionar informações ao PDF
            $pdf->Cell(0, 0, utf8_decode("OUTORGADO: {$outorgado->nome_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("CPF: {$outorgado->cpf_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: {$outorgado->end_outorgado}"), 0, 0, 'L');
            $pdf->Ln(10); // Espaço extra entre cada outorgado
        }

        // $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, '________________________________________________________________________________________', 0, 0, 'L');

        $pdf->Ln(8);
        // Defina as margens manualmente (em mm)
        $margem_esquerda = 10; // Margem esquerda
        $margem_direita = 10;  // Margem direita

        // Texto a ser inserido no PDF
        $text = 'FINS E PODERES: O OUTORGANTE confere ao OUTORGADO amplos e ilimitados poderes para o fim especial de vender a quem quiser, receber valores de venda, transferir para si próprio ou terceiros, em causa própria, locar ou de qualquer forma alienar ou onerar o veículo de sua propriedade com as seguintes características:';

        // Remover quebras de linha manuais, caso existam
        $text = str_replace("\n", ' ', $text);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text), 0, 'J');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 2, "MARCA: $documento->marca", 0, 0, 'L');
        $pdf->Cell(0, 2, "PLACA: $documento->placa", 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "CHASSI: $documento->chassi", 0, 0, 'L');
        $pdf->Cell(0, 2, "COR: $documento->cor", 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "ANO/MODELO: $documento->ano", 0, 0, 'L');
        $pdf->Cell(0, 2, "RENAVAM: $documento->renavam", 0, 1, 'L');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);

        $text2 = $config->texto_final;
        // dd($text2);
        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", ' ', $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$cidade->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita

        $pdf->Ln(5);
        $pdf->Cell(0, 10, '_________________________________________________', 0, 1, 'C');
        $pdf->Cell(0, 5, utf8_decode("$request->nome"), 0, 1, 'C');

        // Definir o nome do arquivo do PDF
        // $nomePDF = 'nome_extraido_' . time() . '.pdf';

        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de public
        $caminhoPDF = storage_path('app/public/procuracoes/'.$documento->placa.'-'.$dataFormatada.'.pdf');
        $urlPDF = asset('storage/procuracoes/'.$documento->placa.'-'.$dataFormatada.'.pdf');
        // dd($urlPDF);
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (! file_exists(storage_path('app/public/procuracoes'))) {
            mkdir(storage_path('app/public/procuracoes'), 0777, true); // Cria a pasta se ela não existir
        }
        // Lógica para gerar a procuração com o endereço
        // ...
        $data = [
            'nome' => $documento->nome,
            'endereco' => strtoupper($endereco),
            'cpf' => $documento->cpf,
            'marca' => $documento->marca,
            'placa' => $documento->placa,
            'chassi' => $documento->chassi,
            'cor' => $documento->cor,
            'ano' => $documento->ano,
            'cidade' => $documento->cidade,
            'renavam' => $documento->renavam,
            'arquivo_doc' => $urlPDF,
            'arquivo_proc' => $caminhoPDF,
        ];
        // Salvar o PDF
        $pdf->Output('F', $caminhoPDF);

        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Localiza o usuário logado
        $user = User::find($userId);

        if (! $user) {
            alert()->error('Usuário não encontrado.');

            return redirect()->back();
        }
        // Mail::to( config('mail.from.address'))->send(new SendEmail($data, $caminhoPDF));
        if (ProcRapida::create($data)) {
            // Obter o ID do usuário logado

            $user->decrement('credito');
            alert()->success('Procuração gerada com sucesso!');

            return redirect()->route('procrapida.index');
        }
    }

    public function show($id)
    {
        $documento = Documento::find($id);

        if (! $documento) {
            return response()->json(['error' => 'Documento não encontrado'], 404);
        }

        return response()->json($documento);
    }
}
