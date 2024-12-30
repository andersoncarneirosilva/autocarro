<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procuracao;
use App\Models\Outorgado;
use App\Models\Cidade;
use App\Models\TextoPoder;
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
        $cidade = Cidade::first();
        
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

        $pdf->Cell(0, 0, "OUTORGANTE: ". strtoupper($request->nome), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(10, 0, "CPF: $request->cpf", 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: " . strtoupper($request->endereco)) . ", " . $request->numero . ", " . strtoupper($request->bairro) . ", " . strtoupper($request->cidade) . "/" . strtoupper($request->estado), 0, 0, 'L');

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
        $text = "FINS E PODERES: O OUTORGANTE confere ao OUTORGADO amplos e ilimitados poderes para o fim especial de vender a quem quiser, receber valores de venda, transferir para si próprio ou terceiros, em causa própria, locar ou de qualquer forma alienar ou onerar o veículo de sua propriedade com as seguintes características:";

        // Remover quebras de linha manuais, caso existam
        $text = str_replace("\n", " ", $text);

        // Calcular a largura disponível para o texto (considerando as margens)
        $largura_disponivel = $pdf->GetPageWidth() - $margem_esquerda - $margem_direita;

        // Adicionar o texto justificado, utilizando a largura calculada
        $pdf->MultiCell($largura_disponivel, 5, utf8_decode($text), 0, 'J');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 2, "MARCA: " . strtoupper($request->marca), 0, 0, 'L');
        $pdf->Cell(0, 2, "PLACA: " . strtoupper($request->placa), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "CHASSI: " . strtoupper($request->chassi), 0, 0, 'L');
        $pdf->Cell(0, 2, "COR: " . strtoupper($request->cor), 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(120, 2, "ANO/MODELO: " . strtoupper($request->ano_modelo), 0, 0, 'L');
        $pdf->Cell(0, 2, "RENAVAM: " . strtoupper($request->renavam), 0, 1, 'L');


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
        $pdf->Cell(0, 10, utf8_decode("$cidade->cidade , $dataPorExtenso"), 0, 1, 'R');  // 'R' para alinhamento à direita



                                                                                        
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "_________________________________________________" , 0, 1, 'C');
        $pdf->Cell(0, 5, utf8_decode("$request->nome"), 0, 1, 'C');

        // Definir o nome do arquivo do PDF
        //$nomePDF = 'nome_extraido_' . time() . '.pdf';

        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de public
        $caminhoPDF = storage_path('app/public/procuracoes/' . strtoupper($request->placa) . '.pdf'); 
        $urlPDF = asset('storage/procuracoes/' . strtoupper($request->placa) . '.pdf'); 
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (!file_exists(storage_path('app/public/procuracoes'))) {
            mkdir(storage_path('app/public/procuracoes'), 0777, true); // Cria a pasta se ela não existir
        }
        $data = [
            'nome' => strtoupper($request->nome),
            'endereco' => strtoupper($request->endereco),  // Endereço em maiúsculas
            // Caminho do arquivo salvo
            'cpf' => $request->cpf,
            'marca' => strtoupper($request->marca),
            'placa' => strtoupper($request->placa),
            'chassi' => strtoupper($request->chassi),
            'cor' => strtoupper($request->cor),
            'ano' => $request->ano_modelo,
            'renavam' => $request->renavam,
            'arquivo_doc' => $urlPDF,
            'arquivo_proc' => $caminhoPDF,
        ];

        // Salvar o PDF
        $pdf->Output('F', $caminhoPDF); 

        //$extension = $request->arquivo->getClientOriginalExtension();
        //$data['arquivo'] = $request->arquivo->storeAs("usuarios/$request->colaborador/Adiantamento/$request->mes/arquivo-$dataAtual" . ".{$extension}");
        //Mail::to( config('mail.from.address'))->send(new SendEmail($data, $caminhoPDF));

        if($this->model->create($data)){
            
            alert()->success('Procuração cadastrada com sucesso!');

            return redirect()->route('procuracoes.index');
        }
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
