<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Procuracao;
use Smalot\PdfParser\Parser;
use FPDF;
use Carbon\Carbon;

class DocumentosController extends Controller
{
    protected $model;

    public function __construct(Documento $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse veículo?";
        confirmDelete($title, $text);

        //$docs = $this->model->getDocumentos(colaborador: $request->colaborador, documento: $request->documento ?? '');
        $docs = Documento::paginate(10);

        return view('documentos.index', compact('docs'));
    }

    // public function create(){
    //     $users = User::all();
    //     return view('documentos.create', compact('users'));
    // }

    public function store(Request $request){

        $arquivo = $request->file('arquivo_doc');
        
        $nomeOriginal = $arquivo->getClientOriginalName();

        
        
        $parser = new Parser();

        $pdf = $parser->parseFile($arquivo);
        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();

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
        $pastaDestino = storage_path('app/public/documentos');
        $urlPDF = asset('storage/documentos/' . $nomeOriginal); 
        if (!file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0777, true); // Cria a pasta
        }

        // Salva o arquivo na pasta
        $caminhoPDF = $pastaDestino . '/' . $nomeOriginal;
        $arquivo->move($pastaDestino, $nomeOriginal);

        // Verifica se o arquivo foi salvo
        if (!file_exists($caminhoPDF)) {
            return response()->json(['error' => 'Erro ao salvar o arquivo.'], 500);
        }

        $data = [
            'marca' => $marca,
            'placa' => $placa,
            'chassi' => $chassi,
            'cor' => $cor,
            'ano' => $anoModelo,
            'renavam' => $renavam,
            'nome' => $nome,
            'cpf' => $cpf,
            'cidade' => $cidade,
            'crv' => $crv,
            'placaAnterior' => $placaAnterior,
            'categoria' => $categoria,
            'motor' => $motor,
            'combustivel' => $combustivel,
            'infos' => $infos,
            'arquivo_doc' => $urlPDF,
        ];


        if($this->model->create($data)){
            alert()->success('Documento cadastrado com sucesso!');

            return redirect()->route('documentos.index');
        } 
    }

    public function destroy($id){
        if(!$user = $this->model->find($id)){
            return redirect()->route('documentos.index');
        }
        
        if($user->delete()){
            alert()->success('Documento excluído com sucesso!');
        }
        return redirect()->route('documentos.index');
    }

    public function gerarProc($id, Request $request) {
        //dd($request);
        $dataAtual = Carbon::now();
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');
        $endereco = $request->endereco; // Captura o endereço
        $documento = Documento::findOrFail($id);
        //$outorgante = $request->nome; 
    //dd($documento->ano);

        
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
        $pdf->Cell(0, 0, "OUTORGANTE: $documento->nome", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, "CPF: $documento->cpf", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: " . strtoupper($endereco)), 0, 0, 'L');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Ln(8);
        $pdf->Cell(0, 0, utf8_decode("OUTORGADO: "), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("CPF: "), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: "), 0, 0, 'L');

        $pdf->Ln(10);

        $pdf->Cell(0, 0, utf8_decode("OUTORGADO: "), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("CPF: "), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: "), 0, 0, 'L');

        $pdf->Ln(8);
        
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');

        $pdf->Ln(8);
        // Defina as margens manualmente (em mm)
        $margem_esquerda = 10; // Margem esquerda
        $margem_direita = 10;  // Margem direita

        // Texto a ser inserido no PDF
        $text = "FINS E PODERES: O OUTORGANTE confere ao OUTORGADO amplos e ilimitados poderes para o fim especial de vender a quem quiser, receber valores de venda, transferir para si próprio ou terceiros, em causa própria, locar ou de qualquer forma alienar ou onerar o veículo de sua propriedade com as seguintes características:";

        // Remover quebras de linha manuais, caso existam
        $text = str_replace("\n", " ", $text);

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

        $text2 = "Assinar requerimentos , com poderes também para requerer, junto aos CRVAS/DETRAN-RS, os processos
de 2ª vias de CRV/CRLV, Baixa Definitiva do veículo, Alterações de informações do veículo, Solicitar
DCPPO e CRLV digital e ATPV-E, fazer declaração de residência ,fazer alteração de informações no
veículo, fazer ocorrência policial de perca de documento do veículo, assinar termo de responsabilidade pela
não apresentaçãode placas e lacre, fazer troca de município ,receber valores por indenização de
Seguradoras ,Assinar contratos de. inclusão e instrumentos de liberação de Alienação e Reserva de
Domínio para si.- próprio ou terceiros, endossar documentos, usar o veículo em apreço, manejando o
mesmo, em qualquer parte do território nacional ou estrangeiro, ficando cível e criminalmente responsável
por qualquer acidente ou ocorrência, pagar taxas, multas e impostos, liberar e retirar o veículo de depósitos
do DETRAN CRD e DELEGACIAS DE POLICIA CIVIL, EPTC ,PRF E POLICIA FEDERAL,BRIGADA
MILITAR , POLICIAL RODOVIA ESTADUAL ,assinar termos de liberação dar declarações e finalmente, usar
e gozar do veículo como coisa sua e sem interferência ou autorização de outros, podendo ainda, requerer,
perante autoridade alfandegária ou aduaneira de País estrangeiro, licença ou permissão de turismo pelo
tempo e prazo que julgar conveniente, podendo substabelecer a presente no todo ou em parte O outorgante
pelo presente instrumento declara-se responsável pelo pagamento de multas e impostos do veículo acima
descrito e caracterizado, até a data da outorga do presente mandato. ESTA PROCURAÇÃO É
AUTORGADA EM CARÁTER IRREVOGAVEL E IRRETRATAVEL, SEM QUALQUER PRESTAÇÃO DE
CONTAS AO PROPRIETÁRIO E HERDEIROS E OUTROS, VISTO TER SIDO QUITADO O PREÇO DO
VALOR DE VENDA DA TABELA DA FIPE NESTA DATA AO PROPRIETÁRIO.";

        // Remover quebras de linha manuais, caso existam
        $text2 = str_replace("\n", " ", $text2);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel2 = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel2, 5, utf8_decode($text2), 0, 'J');
        // Adicionando a data por extenso no PDF
        $pdf->Cell(0, 10, "ESTEIO, $dataPorExtenso", 0, 1, 'R');  // 'R' para alinhamento à direita



                                                                                            
         $pdf->Ln(5);
         $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
         $pdf->Cell(0, 5, "$documento->nome", 0, 1, 'C');

    // Definir o nome do arquivo do PDF
    $nomePDF = 'nome_extraido_' . time() . '.pdf';

    // Caminho para salvar o PDF na pasta 'procuracoes' dentro de public
    $caminhoPDF = storage_path('app/public/procuracoes/' . $documento->nome . '.pdf'); 
    $urlPDF = asset('storage/procuracoes/' . $documento->placa . '.pdf'); 
    //dd($urlPDF);
    // Verificar se a pasta 'procuracoes' existe, se não, cria-la
    if (!file_exists(storage_path('app/public/procuracoes'))) {
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

        if(Procuracao::create($data)){
            alert()->success('Procuração gerada com sucesso!');

            return redirect()->route('procuracoes.index');
        } 
    }

    public function show($id)
{
    $documento = Documento::find($id);

    if (!$documento) {
        return response()->json(['error' => 'Documento não encontrado'], 404);
    }

    return response()->json($documento);
}


    
}
