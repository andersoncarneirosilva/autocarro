<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procuracao;
use App\Models\ConfigProc;
use Smalot\PdfParser\Parser;
use FPDF;
use Carbon\Carbon;
use App\Mail\SendEmail;
use Mail;



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

        $procs = Procuracao::paginate(10);
        
        //dd($config->nome_outorgado);
        return view('procuracoes.index', compact('procs'));
    }

     public function create(){
        return view('procuracoes.create');
    }
    

    public function store(Request $request){

        
        $config = ConfigProc::first();
        //dd($request);
        $dataAtual = Carbon::now();
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');
        // Obter o arquivo PDF
        //$arquivo = $request->file('arquivo_doc')->getRealPath();
        // Obter o arquivo enviado
        $arquivo = $request->file('arquivo_doc');
        $endereco = $request->input('endereco');
//dd($endereco);
         // Obter o nome original do arquivo
    $nomeOriginal = $arquivo->getClientOriginalName();

    // Definir o caminho onde o arquivo será salvo, mantendo o nome original
    $caminhoDestino = $arquivo->storeAs('uploads', $nomeOriginal, 'public');  // Salva em storage/app/public/uploads

        // Obter o caminho absoluto do arquivo salvo
        $caminhoCompleto = storage_path('app/public/' . $caminhoDestino);
        $parser = new Parser();

        $pdf = $parser->parseFile($arquivo);
        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();

            $outorgante = $this->model->extrairNomeOutorgado($textoPagina);
            $cpf = $this->model->extrairCpfOutorgado($textoPagina);
            $marca = $this->model->extrairMarca($textoPagina);
            $chassi = $this->model->extrairChassi($textoPagina);
            $anoModelo = $this->model->extrairAnoModelo($textoPagina);
            $placa = $this->model->extrairPlaca($textoPagina);
            $cor = $this->model->extrairCor($textoPagina);
            $renavam = $this->model->extrairRevanam($textoPagina);
            //dd($renavam);
            

        }
        
        $text = $pdf->getText();
        $pages = $pdf->getPages();
        foreach ($pages as $page) {

            $texto = $page->getText();

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
    $pdf->Cell(0, 0, "OUTORGANTE: $outorgante", 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(10, 0, "CPF: $cpf", 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: " . strtoupper($endereco)), 0, 0, 'L');

    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Ln(8);
    $pdf->Cell(0, 0, utf8_decode("OUTORGADO: $config->nome_outorgado"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, utf8_decode("CPF: $config->cpf_outorgado"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: $config->end_outorgado"), 0, 0, 'L');

    $pdf->Ln(10);

    $pdf->Cell(0, 0, utf8_decode("OUTORGADO: $config->nome_testemunha"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, utf8_decode("CPF: $config->cpf_testemunha"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: $config->end_testemunha"), 0, 0, 'L');

    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 0, "________________________________________________________________________________________", 0, 0, 'L');

    $pdf->Ln(8);
    // Defina as margens manualmente (em mm)
    $margem_esquerda = 10; // Margem esquerda
    $margem_direita = 10;  // Margem direita

    // Texto a ser inserido no PDF
    $text = "$config->texto_poderes";

    // Remover quebras de linha manuais, caso existam
    $text = str_replace("\n", " ", $text);

    // Calcular a largura disponível para o texto (considerando as margens)
    $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

    // Adicionar o texto justificado, utilizando a largura calculada
    $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text), 0, 'J');

    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(120, 2, "MARCA: $marca", 0, 0, 'L');
    $pdf->Cell(0, 2, "PLACA: $placa", 0, 1, 'L'); 
    $pdf->Ln(5);
    $pdf->Cell(120, 2, "CHASSI: $chassi", 0, 0, 'L');
    $pdf->Cell(0, 2, "COR: $cor", 0, 1, 'L');
    $pdf->Ln(5);
    $pdf->Cell(120, 2, "ANO/MODELO: $anoModelo", 0, 0, 'L');
    $pdf->Cell(0, 2, "RENAVAM: $renavam", 0, 1, 'L');

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
    $pdf->Cell(0, 10, "ESTEIO, $dataPorExtenso", 0, 1, 'R');  // 'R' para alinhamento à direita



                                                                                        
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
        $pdf->Cell(0, 5, "$outorgante", 0, 1, 'C');

    // Definir o nome do arquivo do PDF
    //$nomePDF = 'nome_extraido_' . time() . '.pdf';

    // Caminho para salvar o PDF na pasta 'procuracoes' dentro de public
    $caminhoPDF = storage_path('app/public/procuracoes/' . $placa . '.pdf'); 
    $urlPDF = asset('storage/procuracoes/' . $placa . '.pdf'); 
    //dd($urlPDF);
    // Verificar se a pasta 'procuracoes' existe, se não, cria-la
    if (!file_exists(storage_path('app/public/procuracoes'))) {
        mkdir(storage_path('app/public/procuracoes'), 0777, true); // Cria a pasta se ela não existir
    }
    $data = [
        'nome' => $outorgante,
        'endereco' => strtoupper($endereco),  // Endereço em maiúsculas
          // Caminho do arquivo salvo
        'cpf' => $cpf,
        'marca' => $marca,
        'placa' => $placa,
        'chassi' => $chassi,
        'cor' => $cor,
        'ano' => $anoModelo,
        'renavam' => $renavam,
        'arquivo_doc' => $urlPDF,
        'arquivo_proc' => $caminhoPDF,
    ];
 
    // Salvar o PDF
    $pdf->Output('F', $caminhoPDF); 

    //$extension = $request->arquivo->getClientOriginalExtension();
    //$data['arquivo'] = $request->arquivo->storeAs("usuarios/$request->colaborador/Adiantamento/$request->mes/arquivo-$dataAtual" . ".{$extension}");
    Mail::to( config('mail.from.address'))->send(new SendEmail($data, $caminhoPDF));

        if($this->model->create($data)){
             alert()->success('Procuração cadastrada com sucesso!');

             return redirect()->route('procuracoes.index');
         }   
     }

    // public function edit($id){
    //     if(!$cats = $this->model->find($id)){
    //         return redirect()->route('category.index');
    //     }
    //     return view('category.edit', compact('cats'));
    // }

    // public function update(Request $request, $id){
    //     //dd($request);
    //     //dd($data);
    //     $data = $request->all();
    //     if(!$cats = $this->model->find($id))
    //         return redirect()->route('category.index');

    //     if($cats->update($data)){
    //         alert()->success('Categoria editada com sucesso!');
    //         return redirect()->route('category.index');
    //     }
    // }

     public function destroy($id){
         if(!$doc = $this->model->find($id)){
             alert()->error('Erro ao excluír a procuração!');
         }
        
         if($doc->delete()){
             alert()->success('Procuração excluída com sucesso!');
         }
          return redirect()->route('procuracoes.index');
     }
}
