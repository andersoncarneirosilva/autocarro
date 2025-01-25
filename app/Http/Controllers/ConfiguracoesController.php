<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;
use App\Models\ConfigProc;
use App\Models\Outorgado;
use App\Models\Testemunha;
use App\Models\Cidade;
use App\Models\TextoPoder;
use App\Models\TextoInicio;
use App\Models\ModeloProcuracoes;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use FPDF;
use Parsedown;

class ConfiguracoesController extends Controller
{
    protected $model;

    public function __construct(Configuracao $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request)
{
    $title = 'Excluir!';
    $text = "Tem certeza que deseja excluir?";
    confirmDelete($title, $text);

    $userId = Auth::id();
    $user = User::find($userId);

    // Paginar os registros de Outorgado
    $outorgados = Outorgado::paginate(2);

    // Obter registros de ModeloProcuracoes e buscar os "outorgados" relacionados
    $modeloProc = ModeloProcuracoes::all()->map(function ($modelo) {
        // Decodificar o campo "outorgados"
    $outorgadosIds = json_decode($modelo->outorgados, true);
    //dd($outorgadosIds);
    // Buscar os registros correspondentes na tabela "outorgados"
    $modelo->outorgadosDetalhes = Outorgado::whereIn('id', $outorgadosIds)->get();

        return $modelo;
    });


    // Passa os dados necessários para a view
    return view('configuracoes.index', compact('modeloProc', 'outorgados'));
}


public function storeOrUpdate(Request $request)
{
    // Obtém o ID do usuário logado
    $userId = Auth::id();

    // Obtém os textos necessários
    $textoInicio = TextoInicio::first();
    $textoPoder = TextoPoder::first();
    $cidade = Cidade::first();

    // Verifica se o campo "outorgados" foi enviado e é um array
    if ($request->has('outorgados') && is_array($request->outorgados)) {
        // Salva o array de outorgados como JSON
        $outorgadosJson = json_encode($request->outorgados);

        // Verifica se já existe um cadastro na tabela
        $existeCadastro = ModeloProcuracoes::first();

        if ($existeCadastro) {
            // Atualiza o registro existente
            $existeCadastro->update([
                'outorgados' => $outorgadosJson,
                'texto_inicial' => $textoInicio->texto_inicio, // Salva texto_inicial como string
                'texto_final' => $textoPoder->texto_final,    // Salva texto_final como string
                'user_id' => $userId,           // Salva o ID do usuário logado
                'cidade' => $cidade->cidade,
            ]);
        } else {
            // Cria um novo registro
            ModeloProcuracoes::create([
                'outorgados' => $outorgadosJson,
                'texto_inicial' => $textoInicio ? $textoInicio->texto_inicio : null,
                'texto_final' => $textoPoder ? $textoPoder->texto_final : null,
                'user_id' => $userId,
                'cidade' => $cidade ? $cidade->cidade : null,
            ]);
        }
    } else {
        // Retorna erro caso 'outorgados' não seja enviado ou não seja um array
        return redirect()->back()->withErrors(['outorgados' => 'O campo outorgados é obrigatório e deve ser um array.']);
    }

    // Redireciona com mensagem de sucesso
    alert()->success('Outorgado selecionado com sucesso!');

        return redirect()->route('configuracoes.index');
}









    

    public function update(Request $request, $id){
        $doc = ConfigProc::findOrFail($id);
    
        $doc->update($request->all());
    
        alert()->success('Procuração editada com sucesso!');
        return redirect()->route('configuracoes.index');
    }

    public function show($id){
        $configuracao = ConfigProc::find($id);

        if (!$configuracao) {
            return response()->json(['error' => 'Configuração não encontrada'], 404);
        }

        return response()->json($configuracao);
    }

    public function gerarProc()
    {
        $dataAtual = Carbon::now();
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        $outorgados = Outorgado::getOutorgados();
        $textos = TextoPoder::getTextoFinal();
//dd($texto->texto_final);
        //dd($nomes); // Para inspeção completa

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

    $pdf->Cell(0, 0, "OUTORGANTE: _______________________________________", 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(10, 0, "CPF: _______________________________________________", 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, utf8_decode("ENDEREÇO: _______________________________________"), 0, 0, 'L');

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
    $pdf->Cell(120, 2, "MARCA: __________________", 0, 0, 'L');
    $pdf->Cell(0, 2, "PLACA: ______________", 0, 1, 'L'); 
    $pdf->Ln(5);
    $pdf->Cell(120, 2, "CHASSI: __________________", 0, 0, 'L');
    $pdf->Cell(0, 2, "COR: ________________", 0, 1, 'L');
    $pdf->Ln(5);
    $pdf->Cell(120, 2, "ANO/MODELO: ______________", 0, 0, 'L');
    $pdf->Cell(0, 2, "RENAVAM: ____________", 0, 1, 'L');

    $pdf->Ln(8);
    $pdf->SetFont('Arial', '', 11);
    foreach ($textos as $texto) {
    $text2 = "$texto->texto_final";
    }
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
        $pdf->Cell(0, 5, "NOME DO OUTORGANTE", 0, 1, 'C');

    
        // Caminho para salvar o PDF na pasta 'procuracoes' dentro de public
        $caminhoPDF = storage_path('app/public/modeloproc/' . 'modelo_de_procuracao' . '.pdf'); 
        $urlPDF = asset('storage/modeloproc/' . 'modelo_de_procuracao' . '.pdf'); 
        //dd($urlPDF);
        // Verificar se a pasta 'procuracoes' existe, se não, cria-la
        if (!file_exists(storage_path('app/public/modeloproc'))) {
            mkdir(storage_path('app/public/modeloproc'), 0777, true); // Cria a pasta se ela não existir
        }

        $pdf->Output('F', $caminhoPDF); 
        return redirect($urlPDF);
    }
}
