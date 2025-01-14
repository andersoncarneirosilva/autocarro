<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procuracao;
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


class ProcuracaoController extends Controller
{
    protected $model;

    public function __construct(Procuracao $procs)
    {
        $this->model = $procs;
    }


    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir essa procuração?";
        confirmDelete($title, $text);

        $clientes = Cliente::all();

        $procs = $this->model->getSearch(search: $request->search ?? '');
        
        
        return view('procuracoes.index', compact(['procs', 'clientes']));
    }

     public function create(){
        return view('procuracoes.create');
    }
    

    public function store(Request $request){

        $outorgados = Outorgado::all();
        //dd($outorgados);
        $config = TextoPoder::first();
        $textInicio = TextoInicio::first();
        //dd($textInicio);
        $cidades = Cidade::first();
        
        $dataAtual = Carbon::now();
        
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        $cidade = Cidade::first();

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
                return redirect()->route('documentos.index');
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
            $crv = $this->model->extrairCrv($textoPagina);
            $placaAnterior = $this->model->extrairPlacaAnterior($textoPagina);
            $categoria = $this->model->extrairCategoria($textoPagina);
            $motor = $this->model->extrairMotor($textoPagina);
            $combustivel = $this->model->extrairCombustivel($textoPagina);
            $infos = $this->model->extrairInfos($textoPagina);
            //dd($placaAnterior);
        }

            // Garante que a pasta "procuracoes" existe
            $pastaDestino = storage_path('app/public/documento');
            $urlDoc = asset('storage/documento/' . $nomeOriginal); 
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
        $caminhoProc = storage_path('app/public/documentos/procuracoes/' . 'proc_' . strtoupper($placa) . '.pdf'); 
        $urlProc = asset('storage/documentos/procuracoes/' . 'proc_' . strtoupper($placa) . '.pdf'); 
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (!file_exists(storage_path('app/public/documentos/procuracoes'))) {
            mkdir(storage_path('app/public/documentos/procuracoes'), 0777, true); // Cria a pasta se ela não existir
        }
        $data = [
            'nome' => strtoupper($nomeFormatado),
            'endereco' => strtoupper($enderecoFormatado),  // Endereço em maiúsculas
            'cpf' => $cpf,
            'marca' => strtoupper($marca),
            'placa' => strtoupper($placa),
            'chassi' => strtoupper($chassi),
            'cor' => strtoupper($cor),
            'ano' => $anoModelo,
            'renavam' => $renavam,
            'arquivo_doc' => $urlDoc,
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

            return redirect()->route('procuracoes.index');
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
            return redirect()->route('procuracoes.index');
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

        return redirect()->route('procuracoes.index');
    }

}
