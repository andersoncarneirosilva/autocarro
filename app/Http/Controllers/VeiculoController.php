<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;
use App\Models\Outorgado;
use App\Models\Cidade;
use App\Models\TextoPoder;
use App\Models\TextoInicio;
use App\Models\Cliente;
use Smalot\PdfParser\Parser;
use FPDF;
use Carbon\Carbon;
use App\Mail\SendEmail;
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

        $clientes = Cliente::all();

        $procs = $this->model->getSearch(search: $request->search ?? '');
        
        
        return view('veiculos.index', compact(['procs', 'clientes']));
    }

//     public function index(Request $request)
// {
//     // Título e texto para confirmação de exclusão
//     $title = 'Excluir!';
//     $text = "Deseja excluir essa procuração?";
//     confirmDelete($title, $text);

//     // Obter todos os clientes
//     $clientes = Cliente::all();

//     // Obter procurações com base na pesquisa
//     $procs = $this->model->getSearch(search: $request->search ?? '');

//     // Caminho para a pasta de documentos
//     $path = storage_path('app/public/documentos');

//     // Obter o espaço total do sistema de arquivos
//     $totalSpace = disk_total_space($path);

//     // Obter o espaço livre no sistema de arquivos
//     $usedSpace = disk_free_space($path);

//     // Calcular o percentual de espaço utilizado
//     $percentUsed = (($totalSpace - $usedSpace) / $totalSpace) * 100;

//     // Calcular o valor usado em GB
//     $usedGB = number_format(($totalSpace - $usedSpace) / (1024 * 1024 * 1024), 2);

//     // Calcular o valor total em GB
//     $totalGB = number_format($totalSpace / (1024 * 1024 * 1024), 2);

//     // Passar as informações para a view
//     return view('veiculos.index', compact(['procs', 'clientes', 'usedGB', 'percentUsed', 'totalGB']));
// }

     public function create(){
        return view('veiculos.create');
    }
    public function createProcManual(){
        return view('veiculos.create-proc-manual');
    }
    
    public function storeProcManual(Request $request){
        //dd($request);
        $outorgados = Outorgado::all();
        //dd($outorgados);
        $config = TextoPoder::first();
        $textInicio = TextoInicio::first();
        //dd($textInicio);
        $cidades = Cidade::first();
        
        $dataAtual = Carbon::now();
        
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        $cidade = Cidade::first();
       
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
        $text = $textInicio->texto_inicio;

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

        $text2 = "$config->texto_final";

        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", " ", $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$cidades->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita



                                                                                        
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode($request['nome']), 0, 1, 'C');


        // Definir o nome do arquivo do PDF
        //$nomePDF = 'nome_extraido_' . time() . '.pdf';

        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de 'documentos'
        $caminhoProc = storage_path('app/public/documentos/procuracoes/' . strtoupper($request['placa']) . '.pdf'); 
        $urlProc = asset('storage/documentos/procuracoes/' . strtoupper($request['placa']) . '.pdf'); 
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (!file_exists(storage_path('app/public/documentos/procuracoes'))) {
            mkdir(storage_path('app/public/documentos/procuracoes'), 0777, true); // Cria a pasta se ela não existir
        }
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
            'arquivo_doc' => "Não consta",
            'renavam' => $request['renavam'],
            'arquivo_proc' => $urlProc,
        ];
        //dd($urlProc);
        // Salvar o PDF
        $pdf->Output('F', $caminhoProc); 

        //$extension = $request->arquivo->getClientOriginalExtension();
        //$data['arquivo'] = $request->arquivo->storeAs("usuarios/$request->colaborador/Adiantamento/$request->mes/arquivo-$dataAtual" . ".{$extension}");
        //Mail::to( config('mail.from.address'))->send(new SendEmail($data, $caminhoPDF));

        if($this->model->create($data)){
            
            alert()->success('Procuração cadastrada com sucesso!');

            return redirect()->route('veiculos.index');
        }
    }


    public function store(Request $request){

        $outorgados = Outorgado::all();
        //dd($outorgados);
        $config = TextoPoder::first();
        $textInicio = TextoInicio::first();

        $cidades = Cidade::first();
        
        $dataAtual = Carbon::now();
        
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        $cidade = Cidade::first();


        if ($outorgados->isEmpty()) {
            alert()->error('Erro!', 'Por favor, cadastre ao menos um Outorgado antes de prosseguir.')
                ->persistent(true)
                ->autoClose(5000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();
    
            return redirect()->route('veiculos.index');
        }

        if (!$textInicio || !isset($textInicio->texto_inicio)) {
            alert()->error('Erro!', 'Por favor, configure o texto inicial procuração antes de prosseguir.')
                ->persistent(true)
                ->autoClose(5000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();
        
            return redirect()->route('veiculos.index');
        }

        if (!$config || !isset($config->texto_final)) {
            alert()->error('Erro!', 'Por favor, configure o texto final da procuração antes de prosseguir.')
                ->persistent(true)
                ->autoClose(5000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();
        
            return redirect()->route('veiculos.index');
        }

        if (!$cidade || !isset($cidade->cidade)) {
            alert()->error('Erro!', 'Por favor, configure a cidade da procuração antes de prosseguir.')
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
            //dd($placaAnterior);
        }

            // Garante que a pasta "procuracoes" existe
            $pastaDestino = storage_path('app/public/documentos/crlv/');
            $urlDoc = asset('storage/documentos/crlv/' . $nomeOriginal); 
            //dd($urlDoc);
            if (!file_exists($pastaDestino)) {
                mkdir($pastaDestino, 0777, true); // Cria a pasta
            }

            // Salva o arquivo na pasta
            $caminhoDoc = $pastaDestino . '/' . $nomeOriginal;
            $arquivo->move($pastaDestino, $nomeOriginal);

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
        $text = $textInicio->texto_inicio;

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

        $text2 = "$config->texto_final";

        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", " ", $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, utf8_decode("$cidades->cidade, $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita



                                                                                        
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode("$nome"), 0, 1, 'C');

        // Definir o nome do arquivo do PDF
        //$nomePDF = 'nome_extraido_' . time() . '.pdf';

        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de 'documentos'
        $caminhoProc = storage_path('app/public/documentos/procuracoes/' . strtoupper($placa) . '.pdf'); 
        $urlProc = asset('storage/documentos/procuracoes/' . strtoupper($placa) . '.pdf'); 
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (!file_exists(storage_path('app/public/documentos/procuracoes'))) {
            mkdir(storage_path('app/public/documentos/procuracoes'), 0777, true); // Cria a pasta se ela não existir
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

            'arquivo_doc' => $urlDoc,
            'arquivo_proc' => $urlProc,
        ];
        //dd($data);
        // Salvar o PDF
        $pdf->Output('F', $caminhoProc); 

        //$extension = $request->arquivo->getClientOriginalExtension();
        //$data['arquivo'] = $request->arquivo->storeAs("usuarios/$request->colaborador/Adiantamento/$request->mes/arquivo-$dataAtual" . ".{$extension}");
        //Mail::to( config('mail.from.address'))->send(new SendEmail($data, $caminhoPDF));

        if($this->model->create($data)){
            
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


    public function destroy($id){
        // Tenta localizar o documento no banco de dados
        if (!$doc = $this->model->find($id)) {
            alert()->error('Erro ao excluir a procuração!');
            return redirect()->route('veiculos.index');
        }

        // Extrai apenas o nome do arquivo da URL completa
        $nomeArquivo = basename($doc->arquivo_doc); // Retorna "DOC-2024-MARILENE.pdf"
        //dd($nomeArquivo); // Verifique se o nome está correto

        // Monta o caminho completo para o arquivo no servidor
        $arquivo = storage_path('app/public/procuracoes/' . $nomeArquivo);

        // Verifica se o arquivo existe e o exclui
        if (file_exists($arquivo)) {
            unlink($arquivo);
        }

        // Exclui o registro do banco de dados
        if ($doc->delete()) {
            alert()->success('Procuração excluída com sucesso!');
        }

        return redirect()->route('veiculos.index');
    }

    public function storeAtpve(Request $request, $id){
        //dd($request);
        $clienteIds = $request->input('cliente'); // Exemplo: [1, 2, 3]
        $clientes = Cliente::whereIn('id', $clienteIds)->get();
        foreach ($clientes as $cliente) {
        }
        // Verifica se os clientes foram encontrados
    if ($clientes->isEmpty()) {
        return redirect()->back()->with('error', 'Nenhum cliente válido foi encontrado.');
    }
        $cidade = Cidade::first();
        $outorgados = Outorgado::first();
        $textoFinal = TextoPoder::first();
        $textoInicial = TextoInicio::first();
        $cidade = Cidade::first();

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

$this->desenharSublinhado($pdf, 41, 139, $cliente->nome, 100); 
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

    // Salvar o PDF no servidor
    $filePath = storage_path('app/public/documentos/atpves/') . 'atpve_' . $estoque->placa . '.pdf';
    if (!file_exists(storage_path('app/public/documentos/atpves'))) {
        mkdir(storage_path('app/public/documentos/atpves'), 0777, true);
    }
    $pdf->Output('F', $filePath);

    // Retornar o link do PDF para download/visualização
    $fileUrl = asset('storage/documentos/atpves/' . basename($filePath));

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
    // Recuperar o registro do veículo pelo ID
    $veiculo = Veiculo::findOrFail($id);

    // Atualizar o campo 'crv' (caso necessário)
    if ($request->has('crv')) {
        $veiculo->crv = $request->input('crv');
    }

    // Processar os uploads de arquivos
    $this->processFileUpload($request, $veiculo, 'arquivo_proc_assinado', 'documentos/procuracoes_assinadas', 'arquivo_proc_assinado', 'size_proc_pdf');
    $this->processFileUpload($request, $veiculo, 'arquivo_atpve_assinado', 'documentos/atpves_assinadas', 'arquivo_atpve_assinado', 'size_atpve_pdf');

    // Salvar as alterações no banco de dados
    $veiculo->save();

    // Redirecionar com mensagem de sucesso
    alert()->success('Documento enviado com sucesso!');
    return redirect()->route('veiculos.index');
}

/**
 * Processa o upload de um arquivo e salva os detalhes no modelo.
 *
 * @param \Illuminate\Http\Request $request
 * @param \App\Models\Veiculo $veiculo
 * @param string $fileKey Chave do arquivo no request
 * @param string $directoryPath Caminho relativo para salvar o arquivo
 * @param string $dbField Campo do modelo para salvar o URL do arquivo
 * @param string $sizeField Campo do modelo para salvar o tamanho do arquivo
 */
private function processFileUpload($request, $veiculo, $fileKey, $directoryPath, $dbField, $sizeField)
{
    if ($request->hasFile($fileKey)) {
        // Verificar e criar o diretório se necessário
        $storagePath = storage_path("app/public/{$directoryPath}");
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Definir o nome e o caminho completo do arquivo
        $fileName = $veiculo->placa . '_assinado.pdf';
        $filePath = "{$storagePath}/{$fileName}";

        // Salvar o arquivo no caminho especificado
        $request->file($fileKey)->move($storagePath, $fileName);

        // Construir o URL público do arquivo salvo
        $fileUrl = asset("storage/{$directoryPath}/{$fileName}");

        // Salvar o URL completo no banco de dados
        $veiculo->{$dbField} = $fileUrl;

        // Obter o tamanho do arquivo em MB
        $fileSizeInBytes = filesize($filePath);
        $fileSizeInMB = $fileSizeInBytes / (1024 * 1024); // Convertendo para MB
        $veiculo->{$sizeField} = round($fileSizeInMB, 2); // Armazenando com 2 casas decimais
    }
}


}
