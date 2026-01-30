<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailAtpve;
use App\Mail\SendEmailProc;
use App\Models\Cliente;
use App\Models\ModeloProcuracao;
use App\Models\Outorgado;
use App\Models\User;
use App\Models\Multa;
use App\Models\Veiculo;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use FPDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Mail;

use Smalot\PdfParser\Parser;

class VeiculoController extends Controller
{
    protected $model;

    public function __construct(Veiculo $procs)
    {
        $this->model = $procs;
    }

    public function index(Request $request)
{
    $user = Auth::user();
    // LÓGICA ALCECAR: Define qual empresa estamos filtrando
    $empresaId = $user->empresa_id ?? $user->id;
    $search = $request->search;

    // 1. Inicia a busca filtrando pela EMPRESA
    $query = $this->model->where('empresa_id', $empresaId)
                         ->where('status', 'Ativo');

    // 2. Aplica o filtro de busca (se houver)
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('placa', 'LIKE', "%{$search}%")
              ->orWhere('marca', 'LIKE', "%{$search}%")
              ->orWhere('modelo', 'LIKE', "%{$search}%")
              ->orWhere('cpf', 'LIKE', "%{$search}%");
        });
    }

    // 3. Executa a paginação
    $veiculos = $query->orderBy('created_at', 'DESC')
                      ->paginate(10)
                      ->appends($request->all());

    // 4. Dados auxiliares filtrados pela EMPRESA
    // Isso permite que o vendedor veja os clientes e outorgados da loja
    $outorgados = Outorgado::where('empresa_id', $empresaId)->get();
    $clientes = Cliente::where('empresa_id', $empresaId)->get();
    
    $quantidadePaginaAtual = $veiculos->count();
    $quantidadeTotal = $veiculos->total();

    // Verificamos se existe QUALQUER modelo vinculado a essa empresa
    $modeloProc = ModeloProcuracao::where('empresa_id', $empresaId)->exists();
    $modeloOut = Outorgado::where('empresa_id', $empresaId)->exists();

    return view('veiculos.index', compact([
        'clientes',
        'outorgados',
        'veiculos',
        'modeloProc',
        'modeloOut',
        'quantidadePaginaAtual',
        'quantidadeTotal',
    ]));
}

    public function indexArquivados(Request $request)
{
    $user = Auth::user();
    // LÓGICA ALCECAR: Define qual empresa estamos filtrando
    $empresaId = $user->empresa_id ?? $user->id;
    $search = $request->search;

    // 1. Inicia a Query filtrando por Usuário e Status Arquivado
    $query = $this->model->where('user_id', $empresaId)
                         ->where('status', 'Arquivado');

    // 2. Aplica o filtro de busca se houver um termo pesquisado
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('placa', 'LIKE', "%{$search}%")
              ->orWhere('renavam', 'LIKE', "%{$search}%")
              ->orWhere('marca', 'LIKE', "%{$search}%")
              ->orWhere('modelo', 'LIKE', "%{$search}%");
        });
    }

    // 3. Executa a paginação mantendo os filtros na URL (importante para funcionar a troca de página)
    $veiculos = $query->orderBy('updated_at', 'desc')
                      ->paginate(20)
                      ->appends($request->all());

    // 4. Define os contadores baseados no resultado da query
    $quantidadePaginaAtual = $veiculos->count();
    $quantidadeTotal = $veiculos->total(); // Total real considerando a busca

    // 5. Dados auxiliares para o modal e visualização
    $outorgados = Outorgado::where('user_id', $empresaId)->get();
    $clientes = Cliente::where('user_id', $empresaId)->get();
    $modeloProc = ModeloProcuracao::exists();

    // 6. Lógica de cálculo de espaço em disco
    $path = storage_path('app/public/documentos/usuario_' . $empresaId);
    
    

    return view('veiculos.arquivados', compact([
        'clientes',
        'outorgados',
        'veiculos',
        'modeloProc',
        'quantidadePaginaAtual',
        'quantidadeTotal'
    ]));
}

public function indexVendidos(Request $request)
{
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;

    $search = $request->search;

    // 1. CORREÇÃO: Usar a coluna 'empresa_id' e não 'user_id'
    $query = $this->model->where('empresa_id', $empresaId)
                         ->where('status', 'Vendido');

    // 2. Filtro de busca (correto)
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('placa', 'LIKE', "%{$search}%")
              ->orWhere('renavam', 'LIKE', "%{$search}%")
              ->orWhere('marca', 'LIKE', "%{$search}%")
              ->orWhere('modelo', 'LIKE', "%{$search}%");
        });
    }

    // 3. Paginação (correto)
    $veiculos = $query->orderBy('updated_at', 'desc')
                      ->paginate(20)
                      ->appends($request->all());

    $quantidadePaginaAtual = $veiculos->count();
    $quantidadeTotal = $veiculos->total(); 

    // 4. CORREÇÃO: Clientes e Outorgados também pela empresa_id
    $outorgados = Outorgado::where('empresa_id', $empresaId)->get();
    $clientes = Cliente::where('empresa_id', $empresaId)->get();
    
    // 5. CORREÇÃO: Verificar se a empresa tem o modelo
    $modeloProc = ModeloProcuracao::where('empresa_id', $empresaId)->exists();

    // 6. Lógica de caminho (Ajustada para a nova estrutura documentos/ID_VEICULO)
    // Se você mudou para documentos/{id}, o cálculo por pasta de usuário mudou.
    // Mas se quiser manter a estatística por empresa:
    $path = storage_path('app/public/documentos'); 

    return view('veiculos.vendidos', compact([
        'clientes',
        'outorgados',
        'veiculos',
        'modeloProc',
        'quantidadePaginaAtual',
        'quantidadeTotal'
    ]));
}

    public function create()
    {
        return view('veiculos.create');
    }

    public function createProcManual()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $configProc = ModeloProcuracao::where('user_id', $userId)->first();

        // SWEET ALERT
        if (empty($configProc->outorgados)) {
            alert()->error('Erro!', 'Por favor, cadastre ao menos um Outorgado antes de prosseguir.')
                ->persistent(true)
                ->autoClose(5000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();

            return redirect()->route('veiculos.index');
        }

        return view('veiculos.create-proc-manual');
    }

    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // PROC MANUAL

    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function storeProcManual(Request $request)
    {

        $userId = Auth::id();
        $user = User::find($userId);
        $configProc = ModeloProcuracao::where('user_id', $userId)->first();
        $dataAtual = Carbon::now();

        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        // Gerar o PDF com FPDF
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

        $enderecoFormatado = $this->forcarAcentosMaiusculos($request->endereco);
        // dd($enderecoFormatado);
        $nomeFormatado = $this->forcarAcentosMaiusculos($request['nome']);

        // dd($nomeFormatado);

        $pdf->Cell(0, 0, 'OUTORGANTE: '.strtoupper(iconv('UTF-8', 'ISO-8859-1', $nomeFormatado)), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, 'CPF: '.$request['cpf'], 0, 0, 'L');

        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode('ENDEREÇO: '.strtoupper($enderecoFormatado)), 0, 0, 'L');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, '________________________________________________________________________________________', 0, 0, 'L');
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

        // $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, '________________________________________________________________________________________', 0, 0, 'L');

        $pdf->Ln(8);
        // Defina as margens manualmente (em mm)
        $margem_esquerda = 10; // Margem esquerda
        $margem_direita = 10;  // Margem direita

        // Texto a ser inserido no PDF
        $text = $configProc->texto_inicial;

        // Remover quebras de linha manuais, caso existam
        $text = str_replace("\n", ' ', $text);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text), 0, 'J');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 2, 'MARCA: '.strtoupper($request['marca']), 0, 0, 'L');
        $pdf->Cell(0, 2, 'PLACA: '.strtoupper($request['placa']), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, 'CHASSI: '.strtoupper($request['chassi']), 0, 0, 'L');
        $pdf->Cell(0, 2, 'COR: '.strtoupper($request['cor']), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, 'ANO/MODELO: '.strtoupper($request['ano_modelo']), 0, 0, 'L');
        $pdf->Cell(0, 2, 'RENAVAM: '.strtoupper($request['renavam']), 0, 1, 'L');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);

        $text2 = "$configProc->texto_final";

        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", ' ', $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$configProc->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita

        $pdf->Ln(5);
        $pdf->Cell(0, 10, '_________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode($request['nome']), 0, 1, 'C');

        // Define o limite de espaço por usuário (em MB)
        $limiteMb = $user->size_folder;
        $limiteBytes = $limiteMb * 1024 * 1024; // Converte para bytes

        // Caminho para a pasta de documentos do usuário
        $pastaUsuario = "documentos/usuario_{$userId}/";

        // Garante que a pasta do usuário exista
        if (! Storage::disk('public')->exists($pastaUsuario)) {
            Storage::disk('public')->makeDirectory($pastaUsuario, 0777, true);
        }

        // Calcula o espaço total usado na pasta do usuário


        // Caminho para a pasta de procuracoes
        $pastaProc = storage_path('app/public/'.$pastaUsuario.'procuracoes_manual/');
        if (! File::exists($pastaProc)) {
            File::makeDirectory($pastaProc, 0777, true); // Cria a pasta se não existir
        }

        $numeroRandom = rand(1000, 9999);

        $caminhoProc = $pastaProc.strtoupper($request['placa']).'_'.$numeroRandom.'.pdf';
        $urlProc = asset('storage/'.$pastaUsuario.'procuracoes_manual/'.strtoupper($request['placa']).'_'.$numeroRandom.'.pdf');

        // Salvar o PDF
        $pdf->Output('F', $caminhoProc);

        // Agora que o arquivo foi gerado, podemos calcular o tamanho
        // $tamanhoNovoArquivo = filesize($caminhoProc); // Calcula o tamanho do arquivo gerado em bytes
        $sizeProc = filesize($caminhoProc);
        // Verifica se há espaço suficiente


        $input = $request['marca'];
        // Divide a string pelos espaços e barras
        $partes = preg_split('/[\s\/]+/', $input);

        // Pega a primeira palavra (marca)
        $marca = strtoupper($partes[0]);
        // dd($marca);
        $modelo = strtoupper($partes[1]);
        $nomeImagem = 'storage/veiculos/'.strtolower($request['tipo']).'/'.
                        strtolower(str_replace(['/', ' '], '_', $marca)).'_'.
                        strtolower(str_replace(['/', ' '], '_', $modelo)).'_'.
                        strtolower(str_replace(' ', '_', $request['cor'])).'.jpg';

        // Caminho real do arquivo no servidor
        $caminhoImagem = public_path($nomeImagem);

        // Verifica se a imagem existe, senão define a padrão
        if (! file_exists($caminhoImagem)) {
            $nomeImagem = 'storage/veiculos/default.jpg'; // Caminho da imagem padrão
        }
        // DATA PROC MANUAL
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
            'renavam' => $request['renavam'],
            'crv' => $request['tipo_doc'],
            'cidade' => 'Não consta',
            'placaAnterior' => 'Não consta',
            'categoria' => 'Não consta',
            'motor' => 'Não consta',
            'combustivel' => 'Não consta',
            'infos' => 'Não consta',
            'tipo' => $request['tipo'],
            'image' => $nomeImagem,

            'arquivo_doc' => 0,
            'size_doc' => 0,

            'arquivo_proc' => $urlProc,
            'size_proc' => $sizeProc,

            'arquivo_atpve' => 0,
            'size_atpve' => 0,

            'arquivo_proc_assinado' => 0,
            'size_proc_pdf' => 0,

            'arquivo_proc_assinado' => 0,
            'size_atpve_pdf' => 0,
            'status' => 'Disponível',
            'user_id' => $userId,
        ];

        // dd($data);

        if ($user->plano == 'Premium') {
            // Mail::to($user->email)->send(new SendEmailProc($data, $caminhoProc));
        }
        // Criar o registro no banco
        if ($this->model->create($data)) {
            // SAVE PROC MANUAL
            if ($user && ($user->plano == 'Padrão' || $user->plano == 'Pro' || $user->plano == 'Teste')) {
                $user->decrement('credito', 5);
            }

            return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
        } else {
            return back()->with(['error' => 'Erro ao cadastrar a procuração.']);
        }

    }

    

    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // PROC STORE

    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    

   public function cadastroRapido(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    // LÓGICA ALCECAR: Identifica o ID da empresa (Dono)
    $empresaId = $user->empresa_id ?? $userId;


    // 1. Validação do Arquivo
    $request->validate([
        'arquivo_doc' => 'required|mimes:pdf|max:10240',
    ], [
        'arquivo_doc.mimes' => 'O documento deve ser obrigatoriamente um arquivo PDF.',
        'arquivo_doc.max' => 'O arquivo não pode ser maior que 10MB.'
    ]);

    $arquivo = $request->file('arquivo_doc');
    $size_doc = $arquivo->getSize();

    // 2. Leitura do PDF
    try {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($arquivo->getPathname());
        $textoPagina = $pdf->getPages()[0]->getText();
        $linhas = explode("\n", $textoPagina);

        if (!isset($linhas[3]) || trim($linhas[3]) != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {
            return redirect()->route('veiculos.index')
                ->with('error_title', 'Documento Inválido')
                ->with('error', 'O sistema Alcecar aceita apenas CRLV Digital (PDF) oficial emitido a partir de 2024.');
        }
    } catch (\Exception $e) {
        return redirect()->route('veiculos.index')
            ->with('error_title', 'Erro na leitura')
            ->with('error', 'Não foi possível ler os dados do PDF.');
    }

    // 3. Extração de Dados
    $placa = strtoupper($this->model->extrairPlaca($textoPagina));
    
    // VERIFICAÇÃO MULTI-TENANT: Verifica se a placa já existe NA EMPRESA
    if (Veiculo::where('placa', $placa)->where('empresa_id', $empresaId)->exists()) {
        return redirect()->route('veiculos.index')
            ->with('error_title', 'Veículo já cadastrado')
            ->with('error', "A placa $placa já consta na base de dados da sua empresa.");
    }


    $marca = $this->model->extrairMarca($textoPagina);
    $chassi = $this->model->extrairChassi($textoPagina);
    $cor = $this->model->extrairCor($textoPagina);
    $anoExtraido = $this->model->extrairAnoModelo($textoPagina);
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
    $tipo = $this->model->extrairEspecie($textoPagina);
    $potencia = $this->model->extrairPotencia($textoPagina);
    $peso_bruto = $this->model->extrairPesoBruto($textoPagina);
    $cilindrada = $this->model->extrairCilindrada($textoPagina);
    $carroceria = $this->model->extrairCarroceria($textoPagina);
    $exercicio = $this->model->extrairExercicio($textoPagina);

    //dd($exercicio);
//dd($peso_bruto);
    // Lógica de Marca/Modelo
    $textoLimpo = str_starts_with($marca, 'I/') ? substr($marca, 2) : $marca;
    if (str_contains($textoLimpo, '/')) {
        [$marcaReal, $modeloReal] = explode('/', $textoLimpo, 2);
    } else {
        $partes = explode(' ', $textoLimpo, 2);
        $marcaReal = $partes[0] ?? '';
        $modeloReal = $partes[1] ?? '';
    }

    $partesAno = explode('/', $anoExtraido);
    $anoFabricacao = isset($partesAno[0]) ? (int) preg_replace('/\D/', '', $partesAno[0]) : null;
    $anoModelo     = isset($partesAno[1]) ? (int) preg_replace('/\D/', '', $partesAno[1]) : $anoFabricacao;

    $marcaReal = trim(strtoupper($marcaReal));
    if ($marcaReal === 'VW') $marcaReal = 'VOLKSWAGEN';
    if ($marcaReal === 'GM') $marcaReal = 'CHEVROLET';

    // 4. Criação do Registro no Banco
    $data = [
        'nome' => strtoupper($this->forcarAcentosMaiusculos($nome)),
        'cpf' => $cpf,
        'cidade' => $cidade,
        'marca' => $marcaReal,
        'modelo' => trim(strtoupper($modeloReal)),
        'placa' => $placa,
        'chassi' => strtoupper($chassi),
        'cor' => strtoupper($cor),
        'ano_fabricacao' => $anoFabricacao,
        'ano_modelo'     => $anoModelo,
        'renavam' => $renavam,
        'crv' => $crv,
        'placaAnterior' => $placaAnterior,
        'categoria' => $categoria,
        'motor' => $motor,
        'combustivel' => $combustivel,
        'tipo' => $tipo,
        'infos' => $infos,
        'potencia' => $potencia,
        'cilindrada' => $cilindrada,
        'peso_bruto' => $peso_bruto,
        'carroceria' => $carroceria,
        'exercicio' => $exercicio,
        'status' => 'Ativo',
        'status_Veiculo' => 'Aguardando',
        'size_doc' => $size_doc,
        'user_id' => $userId,      // Quem fez o upload
        'empresa_id' => $empresaId // A qual empresa pertence
    ];

    $novoVeiculo = $this->model->create($data);

    if ($novoVeiculo) {
        // CORREÇÃO: Pegando o ID do veículo recém-criado
        $veiculoId = $novoVeiculo->id;

        // 1. Definição da nova estrutura: documentos/usuario_X/veiculo_Y/
        // LÓGICA ALCECAR: Centralizando documentos por usuário e veículo
        $pastaRelativa = "documentos/usuario_{$userId}/veiculo_{$veiculoId}/"; 
        $pastaDestino = storage_path('app/public/' . $pastaRelativa);

        // 2. Criação da pasta com permissões corretas
        if (!file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        // 3. Nome do arquivo padronizado (Placa limpa sem espaços ou traços)
        $placaLimpa = str_replace(['-', ' '], '', $placa);
        $nomeFinalArquivo = "crlv_{$placaLimpa}.pdf";
        
        // 4. Move o arquivo para a nova pasta
        $arquivo->move($pastaDestino, $nomeFinalArquivo);

        // 5. Atualiza o banco com o caminho relativo
        $novoVeiculo->update([
            'arquivo_doc' => $pastaRelativa . $nomeFinalArquivo
        ]);

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo importado e cadastrado com sucesso!');
    }
    
    // Fallback caso falhe a criação
    return redirect()->back()->with('error', 'Erro ao salvar os dados do veículo.');
}


    public function arquivar($id)
{
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;

    // LÓGICA ALCECAR: Busca garantindo que o veículo pertença à EMPRESA
    $veiculo = $this->model->where('id', $id)
        ->where('empresa_id', $empresaId) // Alterado de user_id para empresa_id
        ->first();

    if (!$veiculo) {
        return back()->with('error', 'Veículo não encontrado ou você não tem permissão.');
    }

    $veiculo->update(['status' => 'Arquivado']);

    return back()->with('success', 'Veículo arquivado com sucesso!');
}

public function desarquivar($id)
{
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;

    // LÓGICA ALCECAR: Busca garantindo que o veículo pertença à EMPRESA
    $veiculo = $this->model->where('id', $id)
        ->where('empresa_id', $empresaId) // Alterado de user_id para empresa_id
        ->first();

    if (!$veiculo) {
        return back()->with('error', 'Erro ao restaurar o veículo!');
    }

    // Atualiza para Ativo e LIMPA os dados da venda anterior
    $veiculo->update([
        'status'      => 'Ativo',
        'valor_venda' => null,
        'data_venda'  => null,
        'cliente_id'  => null,
    ]);

    return back()->with('success', 'Veículo restaurado para o estoque e dados de venda limpos!');
}

    public function destroy($id)
    {
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $user = User::find($userId); // Localiza o usuário logado

        // Tenta localizar o documento no banco de dados
        if (! $doc = $this->model->find($id)) {
            return back()->with('error', 'Erro ao excluir a procuração!');

            return redirect()->route('veiculos.index');
        }

        // Recupera o veículo associado ao documento
        $veiculo = \App\Models\Veiculo::where('id', $id)->first();
        if (! $veiculo) {
            return back()->with('error', 'Erro ao excluir a procuração!');

            return redirect()->route('veiculos.index');
        }

        // Caminho base para os arquivos do usuário
        $pastaUsuario = "documentos/usuario_{$userId}/";

        // Nomes e caminhos dos arquivos a serem excluídos
        $arquivosParaExcluir = [
            $pastaUsuario.'crlv/'.basename($doc->arquivo_doc),
            $pastaUsuario.'procuracoes/'.basename($doc->arquivo_proc),
            $pastaUsuario.'atpves/'.basename($doc->arquivo_atpve),
            $pastaUsuario.'atpves_assinadas/'.basename($doc->arquivo_atpve_assinado),
            $pastaUsuario.'procuracoes_assinadas/'.basename($doc->arquivo_proc_assinado),
        ];

        // Verifica e exclui os arquivos
        foreach ($arquivosParaExcluir as $arquivo) {
            if (Storage::disk('public')->exists($arquivo)) {
                Storage::disk('public')->delete($arquivo);
            }
        }

        // Exclui o registro do banco de dados
        if ($doc->delete()) {
            return back()->with('success', 'Veículo excluído com sucesso!');
        } else {
            return back()->with('error', 'Erro ao excluir o veículo!');
        }

        return redirect()->route('veiculos.index');
    }

   


  public function show($id)
{
    $user = Auth::user();
    // LÓGICA ALCECAR: Identifica a empresa
    $empresaId = $user->empresa_id ?? $user->id;
    
    // 1. Buscamos o veículo filtrando pela EMPRESA
    $veiculo = $this->model->with('documentos')
        ->where('empresa_id', $empresaId)
        ->find($id);

    if (!$veiculo) {
        return redirect()->route('veiculos.index')->with('error', 'Veículo não encontrado.');
    }

    // 2. Clientes da Empresa
    $clientes = Cliente::where('empresa_id', $empresaId)
        ->orderBy('nome')
        ->get();
    
    // 3. Vendedores da mesma Empresa
    // Filtramos apenas usuários que pertencem à mesma empresa_id
    $vendedores = User::where('empresa_id', $empresaId)
        ->whereIn('nivel_acesso', ['Vendedor', 'Administrador'])
        ->orderBy('name')
        ->get();

    // 4. Outros dados da Empresa/Veículo
    $outorgados = Outorgado::where('empresa_id', $empresaId)->get();
    $multas = Multa::where('veiculo_id', $id)->get();
    $dadosFipe = null; 

    return view('veiculos.show', compact(
        'veiculo', 
        'outorgados', 
        'clientes', 
        'vendedores', 
        'dadosFipe', 
        'multas'
    ));
}

    public function edit($id)
    {

        if (! $veiculo = $this->model->find($id)) {
            return redirect()->route('veiculos.index');
        }

        return view('veiculos.edit', compact('veiculo'));
    }

    public function cadastroManual()
    {    
        return view('veiculos.create-manual');
    }

public function storeManual(Request $request)
{
    $user = Auth::user();
    // LÓGICA ALCECAR: Identifica a empresa dona do registro
    $empresaId = $user->empresa_id ?? $user->id;

    // 1. Pega os dados exceto imagens e token
    $data = $request->except(['_token', 'images']);

    // 2. Limpeza dos valores monetários
    if ($request->filled('valor')) {
        $data['valor'] = str_replace(['.', ','], ['', '.'], $request->valor);
    }

    if ($request->filled('valor_oferta')) {
        $data['valor_oferta'] = str_replace(['.', ','], ['', '.'], $request->valor_oferta);
    } else {
        $data['valor_oferta'] = null;
    }

    // 3. Limpeza da Kilometragem
    if ($request->filled('kilometragem')) {
        $data['kilometragem'] = preg_replace('/\D/', '', $request->kilometragem);
    }

    // 4. Mapeamento dos Nomes
    $data['marca']  = $request->marca_nome;
    $data['modelo'] = $request->modelo_nome;
    $data['versao'] = $request->versao_nome;

    // 5. Vinculação Multi-tenant e Usuário
    $data['user_id'] = $user->id;
    $data['empresa_id'] = $empresaId; // Vincula à empresa do Anderson ou do João

    // 6. Tratamento de Adicionais e Opcionais
    $data['adicionais'] = json_encode(array_map(function ($item) {
        return ucwords(str_replace('_', ' ', strtolower($item)));
    }, $request->input('adicionais', [])), JSON_UNESCAPED_UNICODE);

    $data['opcionais'] = json_encode(array_map(function ($item) {
        return ucwords(str_replace('_', ' ', strtolower($item)));
    }, $request->input('opcionais', [])), JSON_UNESCAPED_UNICODE);

    // 7. Campos Fixos
    $data['status'] = 'ATIVO';
    $data['categoria'] = 'PARTICULAR';
    $data['placa'] = strtoupper($request->placa);

    // 8. Criação Inicial (Para obter o ID do veículo)
    $veiculo = Veiculo::create($data);

    // 9. Upload de imagens (Nova Estrutura: documentos/ID_DO_VEICULO/fotos/)
    if ($veiculo && $request->hasFile('images')) {
        $imagens = [];
        $diretorioDestino = "documentos/{$veiculo->id}/fotos";

        foreach ($request->file('images') as $image) {
            $path = $image->store($diretorioDestino, 'public');
            $imagens[] = $path;
        }

        // Atualiza o registro com os caminhos das fotos
        $veiculo->update([
            'images' => json_encode($imagens)
        ]);
    }

    return redirect()
        ->route('veiculos.index')
        ->with('success', 'Veículo cadastrado manualmente com sucesso!');
}


    public function destroyDoc($id)
    {
        // dd($id);
        $veiculo = Veiculo::findOrFail($id);

        // Remove o arquivo do armazenamento, se necessário
        if ($veiculo->arquivo_doc && Storage::exists($veiculo->arquivo_doc)) {
            Storage::delete($veiculo->arquivo_doc);
        }

        // Remove o caminho do arquivo do banco de dados
        $veiculo->update(['arquivo_doc' => 0, 'size_doc' => 0]);

        return back()->with('success', 'CRLV excluído com sucesso.');
    }

    
public function removerFoto(Request $request, $id)
{
    $veiculo = Veiculo::findOrFail($id);
    $fotoRemover = $request->input('foto');

    $imagens = json_decode($veiculo->images ?? '[]', true);

    // Remove a imagem da lista
    $imagens = array_filter($imagens, fn($img) => $img !== $fotoRemover);

    // Apaga o arquivo físico (opcional)
    if (Storage::disk('public')->exists($fotoRemover)) {
        Storage::disk('public')->delete($fotoRemover);
    }

    // Atualiza o campo no banco
    $veiculo->images = json_encode(array_values($imagens));
    $veiculo->save();

    return redirect()->back()->with('success', 'Foto removida com sucesso.');
}


public function updateInfo(Request $request, $id)
{
    $veiculo = Veiculo::findOrFail($id);

    // Validação básica para garantir integridade
    $request->validate([
        'kilometragem' => 'required|numeric|min:0',
        'cambio'       => 'required',
    ]);

    $data = [
        // Campos de Uso e Especificações
        'cambio'        => $request->cambio,
        'kilometragem'  => $request->kilometragem,
        'portas'        => $request->portas,
        'especiais'     => $request->especiais,

        // Campos de Identificação (Marca/Modelo/Versão)
        // Usamos o nome vindo do hidden ou mantemos o original se estiver vazio
        'marca'         => $request->marca_nome ?: $veiculo->marca,
        'modelo'        => $request->modelo_nome ?: $veiculo->modelo,
        'versao'        => $request->versao_nome ?: $veiculo->versao,

        // IDs de Referência FIPE
        'fipe_marca_id'  => $request->marca,  // ID vindo do select
        'fipe_modelo_id' => $request->modelo, // ID vindo do select
        'fipe_versao_id' => $request->versao, // ID vindo do select
    ];

    // Se o tipo for Motocicleta, garantimos que portas seja 0 independente do input
    if (strtoupper($veiculo->tipo) == 'MOTOCICLETA') {
        $data['portas'] = 0;
    }

    $veiculo->update($data);

    return redirect()->back()->with('success', 'Informações atualizadas com sucesso!');
}

   public function updateCrv(Request $request, $id)
{
    // Localiza o veículo
    $veiculo = Veiculo::findOrFail($id);

    // Valida apenas o CRV, já que é o único dado enviado
    $request->validate([
        'crv' => 'required|string|max:255',
    ], [
        'crv.required' => 'O número do CRV é obrigatório para esta atualização.'
    ]);

    // Atualiza apenas o campo CRV
    $veiculo->update([
        'crv' => $request->crv
    ]);

    // Retorna para a página anterior (show) com sucesso
    return redirect()->back()
                     ->with('success', 'Número do CRV atualizado com sucesso!');
}

public function updatePrecos(Request $request, $id)
{
    $veiculo = $this->model->findOrFail($id);

    // Limpeza dos dados
    $limparMoeda = function($valor) {
        return (float) str_replace(['.', ','], ['', '.'], $valor);
    };

    $input = $request->all();
    $input['valor'] = $limparMoeda($request->valor);
    $input['valor_oferta'] = $limparMoeda($request->valor_oferta);
    $input['valor_parcela'] = $limparMoeda($request->valor_parcela);
    $input['exibir_parcelamento'] = $request->has('exibir_parcelamento') ? 1 : 0;

    // Validação
    $validator = \Validator::make($input, [
        'valor' => 'required|numeric|min:0.01',
        'valor_oferta' => 'required|numeric|lte:valor',
    ], [
        'valor_oferta.lte' => 'O valor de oferta não pode ser maior que o valor de venda.',
    ]);

    if ($validator->fails()) {
        // O back() com withErrors garante que o modal receba as mensagens
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    if ($veiculo->update($input)) {
        return redirect()->back()->with('success', 'Preços atualizados!');
    }
}

public function updateOpcionais(Request $request, $id)
{
    Log::info("Atualizando opcionais para o ID: {$id}", ['data' => $request->opcionais]);

    try {
        $veiculo = Veiculo::findOrFail($id);

        // Se nenhum checkbox for marcado, o request não envia a chave 'opcionais'
        // Por isso usamos o null coalescing para um array vazio
        $opcionaisArray = $request->input('opcionais', []);

        $veiculo->update([
            'opcionais' => json_encode($opcionaisArray, JSON_UNESCAPED_UNICODE)
        ]);

        return redirect()->route('veiculos.show', $id)->with('success', 'Opcionais atualizados!');

    } catch (\Exception $e) {
        Log::error("Erro ao atualizar opcionais: " . $e->getMessage());
        return back()->with('error', 'Falha ao salvar opcionais.');
    }
}

public function updateModificacoes(Request $request, $id)
{
    try {
        $veiculo = Veiculo::findOrFail($id);
        
        // Captura o array de modificações, se vazio retorna array vazio
        $modificacoes = $request->input('modificacoes', []);

        $veiculo->update([
            'modificacoes' => json_encode($modificacoes, JSON_UNESCAPED_UNICODE)
        ]);

        Log::info("Modificações do veículo {$id} atualizadas por " . auth()->user()->name);

        return redirect()->route('veiculos.show', $id)->with('success', 'Modificações atualizadas com sucesso!');
        
    } catch (\Exception $e) {
        Log::error("Erro ao atualizar modificações do ID {$id}: " . $e->getMessage());
        return back()->with('error', 'Erro ao processar a atualização.');
    }
}

public function updateAdicionais(Request $request, $id)
{
    try {
        $veiculo = Veiculo::findOrFail($id);
        
        // Se nenhum checkbox for marcado, retorna um array vazio
        $adicionais = $request->input('adicionais', []);

        $veiculo->update([
            'adicionais' => json_encode($adicionais, JSON_UNESCAPED_UNICODE)
        ]);

        return redirect()->route('veiculos.show', $id)
                         ->with('success', 'Informações adicionais atualizadas!');
        
    } catch (\Exception $e) {
        Log::error("Erro ao atualizar adicionais do ID {$id}: " . $e->getMessage());
        return back()->with('error', 'Erro ao salvar os dados.');
    }
}

public function updateDescricao(Request $request, $id)
{
    $request->validate([
        'observacoes' => 'nullable|string|max:5000',
    ]);

    try {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->update([
            'observacoes' => $request->observacoes
        ]);

        return redirect()->back()->with('success', 'Descrição atualizada com sucesso!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao atualizar a descrição.');
    }
}

public function uploadFotos(Request $request, $id)
{
    $request->validate([
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
    ]);

    try {
        $veiculo = Veiculo::findOrFail($id);

        $imagensAtuais = json_decode($veiculo->images) ?? [];
        $novasImagens = [];

        if ($request->hasFile('images')) {
            // Define o caminho dinâmico: documentos/ID_DO_VEICULO/fotos
            $diretorioDestino = "documentos/veiculo_{$veiculo->id}/fotos";

            foreach ($request->file('images') as $image) {
                // O Laravel cria as pastas automaticamente se não existirem
                $path = $image->store($diretorioDestino, 'public');
                $novasImagens[] = $path;
            }
        }

        $todasImagens = array_merge($imagensAtuais, $novasImagens);

        $veiculo->update([
            'images' => json_encode($todasImagens)
        ]);

        return back()->with('success', count($novasImagens) . ' fotos adicionadas com sucesso!');

    } catch (\Exception $e) {
        return back()->with('error', 'Erro ao fazer upload das imagens: ' . $e->getMessage());
    }
}

public function deleteFoto($id, $index)
{
    $veiculo = Veiculo::findOrFail($id);
    $imagens = json_decode($veiculo->images, true) ?? [];

    if (isset($imagens[$index])) {
        // Remove arquivo físico
        if (Storage::disk('public')->exists($imagens[$index])) {
            Storage::disk('public')->delete($imagens[$index]);
        }
        
        // Remove do array e reindexa
        unset($imagens[$index]);
        $imagens = array_values($imagens);

        $veiculo->update(['images' => json_encode($imagens)]);

        // Se a requisição for AJAX, retorna JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Foto removida!');
    }

    return response()->json(['success' => false], 404);
}

public function vender(Request $request, $id)
{
    $request->validate([
        'vendedor_id'   => 'required|exists:users,id',
        'cliente_id'    => 'required|exists:clientes,id',
        'valor_venda'   => 'required',
        'data_venda'    => 'required|date',
        // Novos campos (opcionais, dependendo do toggle de parcelamento)
        'entrada'       => 'nullable',
        'qtd_parcelas'  => 'nullable|integer|min:1',
        'taxa_juros'    => 'nullable|numeric',
        'valor_parcela' => 'nullable',
    ]);

    $veiculo = Veiculo::findOrFail($id);

    // Função auxiliar para converter "1.250,50" em "1250.50"
    $limparMoeda = function($valor) {
        if (empty($valor)) return 0;
        $valorSemMilhar = str_replace('.', '', $valor);
        return str_replace(',', '.', $valorSemMilhar);
    };

    // Processamento dos valores financeiros
    $valorVenda   = $limparMoeda($request->valor_venda);
    $valorEntrada = $limparMoeda($request->entrada);
    $valorParcela = $limparMoeda($request->valor_parcela);

    $veiculo->update([
        'status'               => 'Vendido',
        'vendedor_id'          => $request->vendedor_id,
        'cliente_id'           => $request->cliente_id,
        'valor_venda'          => $valorVenda,
        'data_venda'           => $request->data_venda,
        
        // Novos campos financeiros no banco
        'entrada'              => $valorEntrada,
        'qtd_parcelas'         => $request->qtd_parcelas ?? 1,
        'taxa_juros'           => $request->taxa_juros ?? 0,
        'valor_parcela'        => $valorParcela,
        'exibir_parcelamento'  => $request->has('exibir_parcelamento') ? 1 : 0,
    ]);

    return redirect()->route('veiculos.show', $id)
                     ->with('success', 'Venda registrada com sucesso no sistema Alcecar!');
}


public function forcarAcentosMaiusculos($texto)
    {
        // Mapeia as letras acentuadas minúsculas para suas versões maiúsculas
        $mapaAcentos = [
            'á' => 'Á', 'à' => 'À', 'ã' => 'Ã', 'â' => 'Â', 'é' => 'É',
            'è' => 'È', 'ê' => 'Ê', 'í' => 'Í', 'ó' => 'Ó', 'ò' => 'Ò',
            'õ' => 'Õ', 'ô' => 'Ô', 'ú' => 'Ú', 'ù' => 'Ù', 'ç' => 'Ç',
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

    
}
