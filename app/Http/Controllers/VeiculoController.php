<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Smalot\PdfParser\Parser;

use App\Models\Veiculo;
use App\Models\Outorgado;
use App\Models\Cliente;
use App\Models\User;
use App\Models\ModeloProcuracoes;

use Carbon\Carbon;
use App\Mail\SendEmail;
use FPDF;
use Mail;
use TesseractOCR;


class VeiculoController extends Controller
{
    protected $model;

    public function __construct(Veiculo $procs)
    {
        $this->model = $procs;
    }


    public function index(Request $request){
        $title = 'Excluir!';
        $text = "Deseja excluir essa procuração?";
        confirmDelete($title, $text);
        
        $outorgados = Outorgado::all();
        
        $userId = Auth::id();
        $clientes = Cliente::where('user_id', $userId)->get();
        $veiculos = $this->model->getSearch($request->search, $userId);
        $path = storage_path('app/public/documentos/usuario_' . auth()->id());

        // Função para calcular o tamanho total da pasta
        function getFolderSize($folder)
        {
            $size = 0;
            foreach (glob(rtrim($folder, '/') . '/*', GLOB_NOSORT) as $file) {
                $size += is_file($file) ? filesize($file) : getFolderSize($file);
            }
            return $size;
        }

        // Calcular o tamanho usado na pasta
        $usedSpaceInBytes = getFolderSize($path);
        $usedSpaceInMB = $usedSpaceInBytes / (1024 * 1024); // Converter para MB
        $limitInMB = 1; // Limite de 1 MB
        $percentUsed = ($usedSpaceInMB / $limitInMB) * 100; // Percentual usado

        return view('veiculos.index', compact(['clientes', 'usedSpaceInMB', 'percentUsed', 'outorgados', 'limitInMB', 'veiculos']));
    }

    public function create(){
        return view('veiculos.create');
    }

    public function createProcManual(){
        return view('veiculos.create-proc-manual');
    }
    
    public function storeProcManual(Request $request){

        $userId = Auth::id();
        $user = User::find($userId);
        $configProc = ModeloProcuracoes::where('user_id', $userId)->first();
        $dataAtual = Carbon::now();
        
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');
       
        // Gerar o PDF com FPDF
        $pdf = new FPDF();
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();  // Adicionar uma página ao PDF
        //$pdfFpdf->SetFont('Arial', 'B', 16);  // Definir a fonte (Arial, Negrito, tamanho 16)
        $pdf->SetFont('Arial', 'B', 14);

        $titulo = utf8_decode("PROCURAÇÃO");

        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');

        $larguraTitulo = $pdf->GetStringWidth($titulo);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);

        $enderecoFormatado = $this->forcarAcentosMaiusculos($request->endereco);
//dd($enderecoFormatado);
        $nomeFormatado = $this->forcarAcentosMaiusculos($request['nome']);

        //dd($nomeFormatado);
        

        $pdf->Cell(0, 0, "OUTORGANTE: ". strtoupper(iconv("UTF-8", "ISO-8859-1", $nomeFormatado)), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, "CPF: " . $request['cpf'], 0, 0, 'L');

        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: " . strtoupper($enderecoFormatado)), 0, 0, 'L');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Ln(8);

        // Decodificar o array JSON de outorgados
        $outorgadosSelecionados = json_decode($configProc->outorgados, true);

        // Buscar dados dos outorgados na tabela
        $outorgados = Outorgado::whereIn('id', $outorgadosSelecionados)->get();

        // Gerar o PDF com os dados dos outorgados
        foreach ($outorgados as $outorgado) {
            // Adicionar informações ao PDF
            $pdf->Cell(0, 0, utf8_decode("OUTORGADO: {$outorgado->nome_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("CPF: {$outorgado->cpf_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: {$outorgado->end_outorgado}"), 0, 0, 'L');
            $pdf->Ln(10); // Espaço extra entre cada outorgado
        }


        //$pdf->Ln(8);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');

        $pdf->Ln(8);
        // Defina as margens manualmente (em mm)
        $margem_esquerda = 10; // Margem esquerda
        $margem_direita = 10;  // Margem direita

        // Texto a ser inserido no PDF
        $text = $configProc->texto_inicial;

        // Remover quebras de linha manuais, caso existam
        $text = str_replace("\n", " ", $text);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text), 0, 'J');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 2, "MARCA: " . strtoupper($request['marca']), 0, 0, 'L');
        $pdf->Cell(0, 2, "PLACA: " . strtoupper($request['placa']), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "CHASSI: " . strtoupper($request['chassi']), 0, 0, 'L');
        $pdf->Cell(0, 2, "COR: " . strtoupper($request['cor']), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "ANO/MODELO: " . strtoupper($request['ano_modelo']), 0, 0, 'L');
        $pdf->Cell(0, 2, "RENAVAM: " . strtoupper($request['renavam']), 0, 1, 'L');


        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);

        $text2 = "$configProc->texto_final";

        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", " ", $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$configProc->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita



                                                                                        
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode($request['nome']), 0, 1, 'C');


        // Define o limite de espaço por usuário (em MB)
$limiteMb = 1; // Limite de 1 MB
$limiteBytes = $limiteMb * 1024 * 1024; // Converte para bytes

// Caminho para a pasta de documentos do usuário
$pastaUsuario = "documentos/usuario_{$userId}/";

// Garante que a pasta do usuário exista
if (!Storage::disk('public')->exists($pastaUsuario)) {
    Storage::disk('public')->makeDirectory($pastaUsuario, 0777, true);
}

// Calcula o espaço total usado na pasta do usuário
$espacoUsado = 0;
foreach (Storage::disk('public')->allFiles('app/public/' . $pastaUsuario) as $file) {
    $espacoUsado += Storage::disk('public')->size($file);
}

// Caminho para a pasta de procuracoes
$pastaProc = storage_path('app/public/' . $pastaUsuario . 'procuracoes_manual/');
if (!File::exists($pastaProc)) {
    File::makeDirectory($pastaProc, 0777, true); // Cria a pasta se não existir
}

$caminhoProc = $pastaProc . strtoupper($request['placa']) . '.pdf';
$urlProc = asset('storage/' . $pastaUsuario . 'procuracoes_manual/' . strtoupper($request['placa']) . '.pdf');

// Salvar o PDF
$pdf->Output('F', $caminhoProc);

// Agora que o arquivo foi gerado, podemos calcular o tamanho
$tamanhoNovoArquivo = filesize($caminhoProc); // Calcula o tamanho do arquivo gerado em bytes

// Verifica se há espaço suficiente
if (($espacoUsado + $tamanhoNovoArquivo) > $limiteBytes) {
    // Apaga o arquivo gerado se não houver espaço suficiente
    unlink($caminhoProc);
    
    alert()->error('Espaço insuficiente. Você atingiu o limite de armazenamento!');
    return redirect()->route('veiculos.index');
}

// Dados a serem salvos
$data = [
    'nome' => strtoupper($nomeFormatado),
    'endereco' => strtoupper($enderecoFormatado),  // Endereço em maiúsculas
    'cpf' => $request['cpf'],
    'cidade' => strtoupper($request['cidade']),
    'marca' => strtoupper($request['marca']),
    'placa' => strtoupper($request['placa']),
    'chassi' => strtoupper($request['chassi']),
    'cor' => strtoupper($request['cor']),
    'ano' => $request['ano_modelo'],
    'crv' => $request['tipo_doc'],
    'placaAnterior' => "Não consta",
    'categoria' => "Não consta",
    'motor' => "Não consta",
    'combustivel' => "Não consta",
    'infos' => "Não consta",
    'tipo' => $request['tipo'],
    'arquivo_doc' => "Não consta",
    'renavam' => $request['renavam'],
    'arquivo_proc' => $urlProc,
    'user_id' => $userId,
];

// Criar o registro no banco
if ($this->model->create($data)) {
    alert()->success('Procuração cadastrada com sucesso!');
    return redirect()->route('veiculos.index');
} else {
    alert()->error('Erro ao cadastrar a procuração.');
    return back()->withErrors(['message' => 'Erro ao cadastrar a procuração.']);
}
    }


    public function store(Request $request){

        //dd($request);

        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        // Localiza o usuário logado
        $user = User::find($userId);

        $configProc = ModeloProcuracoes::where('user_id', $userId)->first();

        //dd($configProc->outorgados);

        $dataAtual = Carbon::now();
        
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        if (empty($configProc->outorgados)) {
            alert()->error('Erro!', 'Por favor, cadastre ao menos um Outorgado antes de prosseguir.')
                ->persistent(true)
                ->autoClose(5000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();
    
            return redirect()->route('veiculos.index');
        }

        try {
            $validated = $request->validate([
                'arquivo_doc' => 'required|mimes:pdf|max:10240',
            ], [
                'arquivo_doc.mimes' => 'O arquivo deve ser um PDF.',
                'arquivo_doc.required' => 'O arquivo é obrigatório.',
                'arquivo_doc.max' => 'O arquivo não pode ultrapassar 10MB.',
            ]);
            //dd($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            alert()->error('Selecione o documento em pdf!');
            return redirect()->route('documentos.index');
        }
        

        $arquivo = $request->file('arquivo_doc');

        // Define o limite de espaço por usuário (em MB)
        $limiteMb = 1; // Limite de 100 MB
        $limiteBytes = $limiteMb * 1024 * 1024; // Converte para bytes

        // Caminho para a pasta do usuário
        $pastaUsuario = "documentos/usuario_{$userId}/";

        // Garante que a pasta do usuário exista
        if (!Storage::disk('public')->exists($pastaUsuario)) {
            Storage::disk('public')->makeDirectory($pastaUsuario, 0777, true);
        }

        // Calcula o espaço total usado na pasta
        $espacoUsado = 0;
        foreach (Storage::disk('public')->allFiles($pastaUsuario) as $file) {
            $espacoUsado += Storage::disk('public')->size($file);
        }

        // Tamanho do novo arquivo
        $tamanhoNovoArquivo = $arquivo->getSize(); // Em bytes

        // Verifica se há espaço suficiente
        if (($espacoUsado + $tamanhoNovoArquivo) > $limiteBytes) {
            alert()->error('Espaço insuficiente. Você atingiu o limite de armazenamento!');

            return redirect()->route('veiculos.index');
            return back()->withErrors(['message' => 'Espaço insuficiente. Você atingiu o limite de armazenamento.']);
        }
        
        $nomeOriginal = $arquivo->getClientOriginalName();

        
        
        $parser = new Parser();

        $pdf = $parser->parseFile($arquivo);
        
        
        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();
            
            $linhas = explode("\n", $textoPagina);

            if ($linhas[3] != "SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN") {
                alert()->error('Selecione um documento 2024.');
                return redirect()->route('veiculos.index');
            }

            $marca = $this->model->extrairMarca($textoPagina);
            $placa = $this->model->extrairPlaca($textoPagina);
            $chassi = $this->model->extrairChassi($textoPagina);
            $cor = $this->model->extrairCor($textoPagina);
            $anoModelo = $this->model->extrairAnoModelo($textoPagina);
            //dd($anoModelo);
            $renavam = $this->model->extrairRevanam($textoPagina);
            $nome = $this->model->extrairNome($textoPagina);
            $cpf = $this->model->extrairCpf($textoPagina);
            $cidade = $this->model->extrairCidade($textoPagina);
            //dd($cidade);
            $crv = $this->model->extrairCrv($textoPagina);
            $placaAnterior = $this->model->extrairPlacaAnterior($textoPagina);
            $categoria = $this->model->extrairCategoria($textoPagina);
            $motor = $this->model->extrairMotor($textoPagina);
            $combustivel = $this->model->extrairCombustivel($textoPagina);
            $infos = $this->model->extrairInfos($textoPagina);
            $tipo = $this->model->extrairEspecie($textoPagina);
            //dd($tipo);
        }

            // Garante que a pasta "crlv" existe
            $pastaDestino = storage_path('app/public/' . $pastaUsuario . 'crlv/');
            //dd($pastaDestino);
            $urlDoc = asset('storage/' . $pastaUsuario .  'crlv/' . $placa . '.pdf'); // Adiciona a extensão .pdf
            // dd($urlDoc);

            if (!file_exists($pastaDestino)) {
                mkdir($pastaDestino, 0777, true); // Cria a pasta com permissões recursivas
            }

            // Define o caminho completo do arquivo com a extensão .pdf
            $caminhoDoc = $pastaDestino . $placa . '.pdf';

            // Move o arquivo para a pasta com o nome correto
            $arquivo->move($pastaDestino, $placa . '.pdf');


            // Verifica se o arquivo foi salvo
            if (!file_exists($caminhoDoc)) {
                return response()->json(['error' => 'Erro ao salvar o arquivo.'], 500);
            }


        // Gerar o PDF com FPDF
        $pdf = new FPDF();
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();  // Adicionar uma página ao PDF
        //$pdfFpdf->SetFont('Arial', 'B', 16);  // Definir a fonte (Arial, Negrito, tamanho 16)
        $pdf->SetFont('Arial', 'B', 14);

        $titulo = utf8_decode("PROCURAÇÃO");

        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');

        $larguraTitulo = $pdf->GetStringWidth($titulo);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);

        $enderecoFormatado = $this->forcarAcentosMaiusculos($request->endereco);

        $nomeFormatado = $this->forcarAcentosMaiusculos($nome);

        //dd($nomeFormatado);

        $pdf->Cell(0, 0, "OUTORGANTE: ". strtoupper(iconv("UTF-8", "ISO-8859-1", $nomeFormatado)), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, "CPF: $cpf", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: " . strtoupper($enderecoFormatado)), 0, 0, 'L');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Ln(8);

        //$outorgadosSelecionados = ModeloProcuracoes::where('')

        // Decodificar o array JSON de outorgados
        $outorgadosSelecionados = json_decode($configProc->outorgados, true);

        // Buscar dados dos outorgados na tabela
        $outorgados = Outorgado::whereIn('id', $outorgadosSelecionados)->get();

        // Gerar o PDF com os dados dos outorgados
        foreach ($outorgados as $outorgado) {
            // Adicionar informações ao PDF
            $pdf->Cell(0, 0, utf8_decode("OUTORGADO: {$outorgado->nome_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("CPF: {$outorgado->cpf_outorgado}"), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: {$outorgado->end_outorgado}"), 0, 0, 'L');
            $pdf->Ln(10); // Espaço extra entre cada outorgado
        }


        //$pdf->Ln(8);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');

        $pdf->Ln(8);
        // Defina as margens manualmente (em mm)
        $margem_esquerda = 10; // Margem esquerda
        $margem_direita = 10;  // Margem direita

        // Texto a ser inserido no PDF
        $text = $configProc->texto_inicial;

        // Remover quebras de linha manuais, caso existam
        $text = str_replace("\n", " ", $text);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text), 0, 'J');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 2, "MARCA: " . strtoupper($marca), 0, 0, 'L');
        $pdf->Cell(0, 2, "PLACA: " . strtoupper($placa), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "CHASSI: " . strtoupper($chassi), 0, 0, 'L');
        $pdf->Cell(0, 2, "COR: " . strtoupper($cor), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "ANO/MODELO: " . strtoupper($anoModelo), 0, 0, 'L');
        $pdf->Cell(0, 2, "RENAVAM: " . strtoupper($renavam), 0, 1, 'L');


        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);

        $text2 = "$configProc->texto_final";

        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", " ", $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$configProc->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita

                                                                                        
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode("$nome"), 0, 1, 'C');

        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de 'documentos'
        $caminhoProc = storage_path('app/public/' . $pastaUsuario . 'procuracoes/' . strtoupper($placa) . '.pdf'); 
        $urlProc = asset('storage/' . $pastaUsuario . 'procuracoes/' . strtoupper($placa) . '.pdf'); 
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (!file_exists(storage_path('app/public/' . $pastaUsuario . '/procuracoes'))) {
            mkdir(storage_path('app/public/' . $pastaUsuario . '/procuracoes'), 0777, true); // Cria a pasta se ela não existir
        }
        $data = [
            'nome' => strtoupper($nomeFormatado),
            'endereco' => strtoupper($enderecoFormatado),  // Endereço em maiúsculas
            'cpf' => $cpf,
            'cidade' => $cidade,
            'marca' => strtoupper($marca),
            'placa' => strtoupper($placa),
            'chassi' => strtoupper($chassi),
            'cor' => strtoupper($cor),
            'ano' => $anoModelo,
            'renavam' => $renavam,
            'crv' => $crv,
            'placaAnterior' => $placaAnterior,
            'categoria' => $categoria,
            'motor' => $motor,
            'combustivel' => $combustivel,
            'infos' => $infos,
            'tipo' => $tipo,
            'arquivo_doc' => $urlDoc,
            'arquivo_proc' => $urlProc,

            'user_id' => $userId,
        ];

        // Salvar o PDF
        $pdf->Output('F', $caminhoProc); 

        //Mail::to( config('mail.from.address'))->send(new SendEmail($data, $caminhoPDF));

        if($this->model->create($data)){
            $user->decrement('credito');
            alert()->success('Veículo cadastrado com sucesso!');

            return redirect()->route('veiculos.index');
        }
    } 

    function forcarAcentosMaiusculos($texto){
        // Mapeia as letras acentuadas minúsculas para suas versões maiúsculas
        $mapaAcentos = [
            'á' => 'Á', 'à' => 'À', 'ã' => 'Ã', 'â' => 'Â', 'é' => 'É', 
            'è' => 'È', 'ê' => 'Ê', 'í' => 'Í', 'ó' => 'Ó', 'ò' => 'Ò',
            'õ' => 'Õ', 'ô' => 'Ô', 'ú' => 'Ú', 'ù' => 'Ù', 'ç' => 'Ç'
        ];
        
        // Substitui as letras minúsculas acentuadas pelas versões maiúsculas
        $texto = strtr($texto, $mapaAcentos);

        // Substituições de caracteres "estranhos" causados por problemas de codificação
        $substituicoesCodificacao = [
            'Ã‘' => 'Ñ',   // Para corrigir "Ã‘" que deveria ser "Ñ"
            'Ã©' => 'é',   // Para corrigir "Ã©" que deveria ser "é"
            'Ã´' => 'ô',   // Para corrigir "Ã´" que deveria ser "ô"
            'Ã•' => 'Á',
            // Adicione outras substituições conforme necessário
        ];

        // Realiza as substituições
        $texto = strtr($texto, $substituicoesCodificacao);

        // Retorna o texto já com as letras acentuadas forçadas para maiúsculas e a correção de codificação
        return $texto;
    }


    public function destroy($id)
{
    $userId = Auth::id(); // Obtém o ID do usuário autenticado
    $user = User::find($userId); // Localiza o usuário logado

    // Tenta localizar o documento no banco de dados
    if (!$doc = $this->model->find($id)) {
        alert()->error('Erro ao excluir a procuração!');
        return redirect()->route('veiculos.index');
    }

    // Recupera o veículo associado ao documento
    $veiculo = \App\Models\Veiculo::where('id', $id)->first();
    if (!$veiculo) {
        alert()->error('Veículo não encontrado para o documento!');
        return redirect()->route('veiculos.index');
    }

    // Caminho base para os arquivos do usuário
    $pastaUsuario = "documentos/usuario_{$userId}/";

    // Nomes e caminhos dos arquivos a serem excluídos
    $arquivosParaExcluir = [
        $pastaUsuario . 'crlv/' . basename($doc->arquivo_doc), // CRLV
        $pastaUsuario . 'procuracoes/' . basename($doc->arquivo_doc), // Procuração
        $pastaUsuario . 'atpves/' . 'atpve_' . basename($doc->arquivo_doc), // ATPVE
        $pastaUsuario . 'atpves_assinadas/' . $veiculo->placa . '_assinado.pdf', // ATPVE Assinada
        $pastaUsuario . 'procuracoes_assinadas/' . $veiculo->placa . '_assinado.pdf', // Procuração Assinada
    ];

    // Verifica e exclui os arquivos
    foreach ($arquivosParaExcluir as $arquivo) {
        if (Storage::disk('public')->exists($arquivo)) {
            Storage::disk('public')->delete($arquivo);
        }
    }

    // Exclui o registro do banco de dados
    if ($doc->delete()) {
        alert()->success('Procuração excluída com sucesso!');
    } else {
        alert()->error('Erro ao excluir a procuração!');
    }

    return redirect()->route('veiculos.index');
}


    public function storeAtpve(Request $request, $id){

        $userId = Auth::id();
        
        $user = User::find($userId);
        $configProc = ModeloProcuracoes::first();
        
        $clienteId = $request->input('cliente');
        //dd($clienteIds);
        $cliente = Cliente::whereIn('id', $clienteId)->first();
        //dd($cliente->nome);
        // foreach ($clientes as $cliente) {
        // }
        
        if (empty($cliente)) {
            return redirect()->back()->with('error', 'Nenhum cliente válido foi encontrado.');
        }

        $outorgados = Outorgado::first();

        $estoque = Veiculo::find($id);
        //dd($estoque);
        $dataAtual = Carbon::now();
        
        $dataDia = $dataAtual->translatedFormat('d');
        $dataMes = $dataAtual->translatedFormat('m');
        $dataAno = $dataAtual->translatedFormat('Y');

        
        // Criar o PDF com FPDF
        $pdf = new FPDF();
        $pdf->SetMargins(30, 30, 30);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);

        $titulo = utf8_decode("POP 2");
        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'ANEXO 2 - REQUERIMENTO DE PREENCHIMENTO DA ATPV-e', 0, 1, 'C');
        $pdf->Ln(10);

        // Corpo do documento
        $pdf->SetFont('Arial', '', 10);
        //$pdf->MultiCell(0, 8, "Eu, ");

        // Definir posição para o nome e sublinhar apenas a informação dinâmica
$x = $pdf->GetX();
$y = $pdf->GetY();

// Posição para o nome e sublinhado
$pdf->Text($x, $y, "Eu, ");
$x += $pdf->GetStringWidth("Eu, "); // Ajusta o X para o nome

// Reduz a distância entre "Eu," e o nome do outorgado
$x += 0; // Ajuste fino para aproximar o nome de "Eu,"

// Sublinha apenas o nome do outorgado
$this->desenharSublinhado($pdf, $x, 60, $outorgados->nome_outorgado, 140); // Chama o método dentro do controlador
$x += 140; // Ajuste após o nome sublinhado


// Continua o texto após o nome
$pdf->Text($x, $y, ", ");
$pdf->Ln(10);

// Agora começa uma nova linha para o "CPF/CNPJ"
$pdf->Text($x = 30, $y = $pdf->GetY(), "CPF/CNPJ:");
$x += $pdf->GetStringWidth("CPF/CNPJ:"); // Ajusta o X para o CPF/CNPJ

// Sublinha apenas o CPF/CNPJ
$this->desenharSublinhado($pdf, $x, 69, $outorgados->cpf_outorgado, 56); // Chama o método dentro do controlador para o CPF/CNPJ
$x += 56; // Ajuste após o CPF/CNPJ sublinhado

// Continua o texto após o CPF/CNPJ
$pdf->Text($x, $y, ", requeiro ao DETRAN/RS, o preenchimento da");
$pdf->Ln(10); // Faz a quebra de linha para a próxima parte do texto


$pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', "ATPV-e, relativo ao veículo Placa:"));
$x += $pdf->GetStringWidth("ATPV-e, relativo ao veículo Placa:");

// Sublinha a "Placa"
$this->desenharSublinhado($pdf, 84, 78, $estoque->placa, 20); // Sublinha a "Placa"
$x += 20; // Ajuste após a "Placa" sublinhada

// Continua o texto após a "Placa"
$pdf->Text($x, $y, ". Chassi:");
$x += $pdf->GetStringWidth(". Chassi:"); // Ajuste para "Chassi"

// Sublinha o "Chassi"
$this->desenharSublinhado($pdf, $x, 78, $estoque->chassi, 57); // Sublinha o "Chassi"
$x += 57; // Ajuste após o "Chassi" sublinhado

$pdf->Ln(10); // Linha em branco após o texto

// Linha com "Renavam {$renavam} Marca/Modelo {$marca}"
$pdf->Text($x = 30, $y = $pdf->GetY(), "Renavam:");
$x += $pdf->GetStringWidth("Renavam:"); // Ajuste para "Renavam"

// Sublinha o "Renavam"
$this->desenharSublinhado($pdf, $x, 87, $estoque->renavam, 54); // Sublinha o "Renavam"
$x += 54; // Ajuste após o "Renavam" sublinhado

// Continua o texto após "Renavam"
$pdf->Text($x, $y, " Marca/Modelo ");
$x += $pdf->GetStringWidth(" Marca/Modelo "); // Ajuste para "Marca/Modelo"

// Sublinha o "Marca/Modelo"
$this->desenharSublinhado($pdf, $x, 87, $estoque->marca, 53); // Sublinha o "Marca/Modelo"
$x += 53; // Ajuste após o "Marca/Modelo" sublinhado

$pdf->Ln(10); // Linha em branco após o texto

// Agora vai para a nova linha para "PROPRIETÁRIO VENDEDOR:"
$pdf->SetFont('Arial', 'B', 10);
$pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', "PROPRIETÁRIO VENDEDOR:"));
$x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', "PROPRIETÁRIO VENDEDOR:"));  // Ajusta o X para "PROPRIETÁRIO VENDEDOR:"
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(7);

// Posição do texto "e-mail: despachanteluis@hotmail.com"
$pdf->Text($x = 30, $y = $pdf->GetY(), "e-mail: ");

// Calcula a largura do texto do email
$emailText = "e-mail: ";
$x += $pdf->GetStringWidth($emailText); // Atualiza a posição X após o texto

// Sublinha o email
$this->desenharSublinhado($pdf, 42, 103, "fernandofantinel@hotmail.com", 80); // Sublinha apenas o email
$x += 80; // Ajuste após o "Marca/Modelo" sublinhado

$pdf->Ln(20); // Linha em branco após o texto


// Agora vai para a nova linha para "IDENTIFICAÇÃO DO ADQUIRENTE"
$pdf->SetFont('Arial', 'B', 10);
$pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', "IDENTIFICAÇÃO DO ADQUIRENTE"));
$x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', "IDENTIFICAÇÃO DO ADQUIRENTE"));  // Ajusta o X para "IDENTIFICAÇÃO DO ADQUIRENTE"
$pdf->SetFont('Arial', '', 10);
// Linha em branco após o título
$pdf->Ln(8);

$pdf->Text($x = 30, $y = $pdf->GetY(), "CPF/CNPJ:");
$x += $pdf->GetStringWidth("CPF/CNPJ:"); // Ajuste para "CPF/CNPJ:"

// Sublinha o CPF
$this->desenharSublinhado($pdf, $x, 130, $cliente->cpf, 93); // Sublinha o CPF
$x += 93; // Ajuste após o CPF sublinhado

$pdf->Ln(10);

$pdf->Text($x = 30, $y = $pdf->GetY(), "Nome:");
$x += $pdf->GetStringWidth("Nome:");

$this->desenharSublinhado($pdf, 41, 139, iconv('UTF-8', 'ISO-8859-1', $cliente->nome), 100); 
$x += 100;

$pdf->Ln(10);

$pdf->Text($x = 30, $y = $pdf->GetY(), "e-mail: ");
$x += $pdf->GetStringWidth("e-mail:"); // Ajuste para "CPF/CNPJ:"

// Sublinha o CPF
$this->desenharSublinhado($pdf, 41, 148, $cliente->email, 100); // Sublinha o CPF
$x += 100;

$pdf->Ln(20); // Linha em branco após o CPF


$pdf->SetFont('Arial', 'B', 10);
$pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', "ENDEREÇO DO ADQUIRENTE"));
$x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', "ENDEREÇO DO ADQUIRENTE"));
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10); // Linha em branco após o CPF
$pdf->Text($x = 30, $y = $pdf->GetY(), "CEP:");
$x += $pdf->GetStringWidth("CEP:"); // Ajuste para "Renavam"

// Sublinha o "Renavam"
$this->desenharSublinhado($pdf, $x, 177, $cliente->cep, 40); // Sublinha o "Renavam"
$x += 40;

$pdf->Text($x, $y, " UF:");
$x += $pdf->GetStringWidth(" UF:");

$this->desenharSublinhado($pdf, $x, 177, $cliente->estado, 40);
$x += 40;

$pdf->Text($x, $y, iconv('UTF-8', 'ISO-8859-1', " MUNICÍPIO:"));
$x += $pdf->GetStringWidth(" MUNICÍPIO:");

$this->desenharSublinhado($pdf, 146, 177, $cliente->cidade, 40);
$x += 40;

$pdf->Ln(10);


// Posição inicial do texto
$x = 30;
$y = $pdf->GetY();
$pdf->Text($x, $y, "Logradouro:Rua/Av.");

// Ajusta posição para o endereço e sublinha
$x += $pdf->GetStringWidth("Logradouro:Rua/Av.");
$endereco = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $cliente->endereco);
$this->desenharSublinhado($pdf, $x, 186, $endereco, 80);

$x += 80;

// Texto "N."
$pdf->Text(142, $y, " N.");
$x += $pdf->GetStringWidth(" N.");

// Ajusta para o número e sublinha
$this->desenharSublinhado($pdf, 146, 186, $cliente->numero, 40);
$x += 100;

$pdf->Ln(10); // Linha em branco após o texto


// Posição inicial do texto
$x = 30;
$y = $pdf->GetY();
$pdf->Text($x, $y, "Complemento:");
$x += $pdf->GetStringWidth("Complemento:");
$this->desenharSublinhado($pdf, $x, 195, $cliente->complemento, 40);
$x += 40;

// Texto "N."
$pdf->Text($x, $y, " Bairro:");
$x += $pdf->GetStringWidth(" Bairro:");

// Ajusta para o número e sublinha
$this->desenharSublinhado($pdf, $x, 195, $cliente->bairro, 40);
$x += 100;

$pdf->Ln(10); // Linha em branco após o texto

$pdf->SetFont('Arial', 'B', 10);

// Posição inicial do texto
$x = 30;
$y = $pdf->GetY();
$pdf->Text($x, $y, "Valor:");
// Ajusta posição para o endereço e sublinha
$x += $pdf->GetStringWidth("Valor:");
$this->desenharSublinhado($pdf, $x, 204, "R$ " . $request['valor'], 40);
$x += 40;

$pdf->Ln(10);

$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1', "Declaro que li, estou de acordo e sou responsável pelas informações acima."), 0, 1, 'C');

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);


// Define a posição inicial
$x = 30;
$y = $pdf->GetY();

// Exibe o texto fixo "Data"
$pdf->SetFont('Arial', '', 10);
$pdf->Text($x, $y, "Data: ");

// Ajusta a posição para o primeiro campo (dia)
$x += $pdf->GetStringWidth("Data: "); // Move o cursor para a direita
$this->desenharSublinhado($pdf, $x, 231, $dataDia, 8); // Campo do dia sublinhado
$x += 8; // Ajusta após o sublinhado do dia

// Adiciona o separador "/"
$pdf->Text($x, $y, " / ");
$x += $pdf->GetStringWidth(" / "); // Move o cursor após o "/"

// Sublinha o campo do mês
$this->desenharSublinhado($pdf, $x, 231, $dataMes, 8); // Campo do mês sublinhado
$x += 8; // Ajusta após o sublinhado do mês

// Adiciona o separador "/"
$pdf->Text($x, $y, " / ");
$x += $pdf->GetStringWidth(" / "); // Move o cursor após o "/"

// Sublinha o campo do ano (20____)
$this->desenharSublinhado($pdf, $x, 231, $dataAno, 10); // Campo do ano sublinhado
$x += 15; // Ajusta após o sublinhado do ano

$pdf->Ln(20); // Linha em branco após o texto



    $pdf->Cell(0, 8, "__________________________________________", 0, 1, 'C');
    $pdf->Cell(0, 8, "Assinatura do vendedor/representante legal", 0, 1, 'C');


    // Define o limite de espaço por usuário (em MB)
$limiteMb = 1; // Limite de 1 MB
$limiteBytes = $limiteMb * 1024 * 1024; // Converte para bytes

// Define o ID do usuário
$pastaUsuario = "documentos/usuario_{$userId}/";

// Garante que a pasta do usuário exista
if (!Storage::disk('public')->exists($pastaUsuario)) {
    Storage::disk('public')->makeDirectory($pastaUsuario, 0777, true);
}

// Calcula o espaço total usado na pasta
$espacoUsado = 0;
foreach (Storage::disk('public')->allFiles($pastaUsuario) as $file) {
    $espacoUsado += Storage::disk('public')->size($file);
}

// Caminho para salvar o PDF gerado
$pastaAtpves = $pastaUsuario . 'atpves/';
if (!Storage::disk('public')->exists($pastaAtpves)) {
    Storage::disk('public')->makeDirectory($pastaAtpves, 0777, true);
}

$fileName = 'atpve_' . $estoque->placa . '.pdf';
$filePath = $pastaAtpves . $fileName;

// Verifica se o arquivo já existe
if (Storage::disk('public')->exists($filePath)) {
    // Remove o arquivo existente
    Storage::disk('public')->delete($filePath);
}

// Gera o arquivo PDF
$pdfContent = $pdf->Output('S'); // Salva o conteúdo do PDF em formato string
Storage::disk('public')->put($filePath, $pdfContent);

// Calcula o tamanho do novo arquivo
$tamanhoNovoArquivo = Storage::disk('public')->size($filePath); // Em bytes


// Verifica se há espaço suficiente
if (($espacoUsado + $tamanhoNovoArquivo) > $limiteBytes) {
    // Remove o arquivo PDF temporário caso o limite seja excedido
    unlink($filePath);

    alert()->error('Espaço insuficiente. Você atingiu o limite de armazenamento!');
    return redirect()->route('veiculos.index')->withErrors(['message' => 'Espaço insuficiente. Você atingiu o limite de armazenamento.']);
}

// Retornar o link do PDF para download/visualização
$fileUrl = asset('storage/' . $pastaAtpves . 'atpve_' . $estoque->placa . '.pdf');

$data = [
    'arquivo_atpve' => $fileUrl,
];


    //dd($data);
    // Busca o registro pelo ID e atualiza
    $record = $this->model->findOrFail($id);
    $record->update($data);

    alert()->success('ATPVe gerada com sucesso!');

    return redirect()->route('veiculos.index');
}

function desenharSublinhado($pdf, $x, $y, $texto, $largura) {
    $pdf->SetXY($x, $y);
    $pdf->Cell($largura, 0, $texto, 0, 0, 'L');
    $pdf->Line($x, $y + 2, $x + $largura, $y + 2); // Linha sublinhada
}

public function show($id){
    if(!$user = $this->model->find($id)){
        return redirect()->route('users.index');
    }

    $title = 'Excluir!';
    $text = "Deseja excluir esse usuário?";
    confirmDelete($title, $text);
    
    return view('veiculos.show', compact('user'));
}

public function edit($id){
        
    if(!$veiculo = $this->model->find($id)){
        return redirect()->route('users.index');
    }

    return view('veiculos.edit', compact('veiculo'));
}

public function update(Request $request, $id)
{
    $userId = Auth::id(); // Obtém o ID do usuário autenticado
    
    // Recuperar o registro do veículo pelo ID
    $veiculo = Veiculo::findOrFail($id);

    // Atualizar o campo 'crv' (caso necessário)
    if ($request->has('crv')) {
        $veiculo->crv = $request->input('crv');
    }

    // Caminho base para o usuário
    $pastaUsuario = "documentos/usuario_{$userId}/";

    // Processar os uploads de arquivos
    $this->processFileUpload($request, $veiculo, 'arquivo_proc_assinado', $pastaUsuario . 'procuracoes_assinadas', 'arquivo_proc_assinado', 'size_proc_pdf', 10); // Limite de 10 MB
    $this->processFileUpload($request, $veiculo, 'arquivo_atpve_assinado', $pastaUsuario . 'atpves_assinadas', 'arquivo_atpve_assinado', 'size_atpve_pdf', 10); // Limite de 10 MB

    // Salvar as alterações no banco de dados
    $veiculo->save();

    // Redirecionar com mensagem de sucesso
    alert()->success('Documento enviado com sucesso!');
    return redirect()->route('veiculos.edit', $id);
}

private function processFileUpload($request, $veiculo, $fileKey, $storagePath, $fieldName, $sizeFieldName, $limiteMb)
{
    $limiteBytes = $limiteMb * 1024 * 1024; // Converte o limite para bytes

    // Garante que a pasta do usuário exista no disco 'public'
    if (!Storage::disk('public')->exists($storagePath)) {
        Storage::disk('public')->makeDirectory($storagePath);
    }

    // Calcula o espaço total usado na pasta
    $espacoUsado = 0;
    foreach (Storage::disk('public')->allFiles($storagePath) as $file) {
        $espacoUsado += Storage::disk('public')->size($file);
    }

    // Processa o upload se o arquivo estiver presente
    if ($request->hasFile($fileKey)) {
        $arquivo = $request->file($fileKey);

        // Tamanho do novo arquivo
        $tamanhoNovoArquivo = $arquivo->getSize();

        // Verifica se há espaço suficiente
        if (($espacoUsado + $tamanhoNovoArquivo) > $limiteBytes) {
            alert()->error("Espaço insuficiente para upload de {$fileKey}. Você atingiu o limite de armazenamento!");

            // Interrompe o fluxo e redireciona
            return redirect()->route('veiculos.edit', $veiculo->id)->withErrors(['message' => 'Espaço insuficiente.']);
        }

        // Salva o arquivo no disco 'public' e retorna o caminho correto
        $fileName = $veiculo->placa . '_assinado.pdf';
        $filePath = $arquivo->storeAs($storagePath, $fileName, ['disk' => 'public']);

        // Atualiza os campos no modelo
        $veiculo->$fieldName = Storage::disk('public')->url($filePath); // URL pública do arquivo
        $veiculo->$sizeFieldName = $tamanhoNovoArquivo; // Salva o tamanho do arquivo no banco
    }
}


function verificarEspaco($userId, $arquivo)
{
    // Define o limite de espaço em MB
    $limiteMb = 100; // Limite de 100 MB
    $limiteBytes = $limiteMb * 1024 * 1024; // Convertido para bytes

    // Caminho para a pasta do usuário
    $pastaUsuario = "documentos/usuario_{$userId}/";

    // Calcula o espaço total usado na pasta
    $espacoUsado = 0;
    if (Storage::exists($pastaUsuario)) {
        foreach (Storage::allFiles($pastaUsuario) as $file) {
            $espacoUsado += Storage::size($file);
        }
    }

    // Tamanho do novo arquivo
    $tamanhoNovoArquivo = $arquivo->getSize(); // Tamanho em bytes

    // Verifica se ultrapassa o limite
    if (($espacoUsado + $tamanhoNovoArquivo) > $limiteBytes) {
        return false; // Espaço excedido
    }

    return true; // Espaço disponível
}


}
