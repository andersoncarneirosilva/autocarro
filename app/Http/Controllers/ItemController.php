<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use FPDF;
use Illuminate\Support\Facades\Response;
class ItemController extends Controller
{
    public function __construct(Item $itens)
    {
        $this->model = $itens;
    }

    public function index()
{
    $itens = Item::paginate(10);
    return view('produtos.index', compact('itens'));
}




public function store(Request $request)
{
    $marcador = $request['marcador'];
    $parser = new \Smalot\PdfParser\Parser;
    $arquivo = $request->file('arquivo_doc');
    $pdfParser = $parser->parseFile($arquivo);

    $produtos = [];

    foreach ($pdfParser->getPages() as $pagina) {
        $textoPagina = $pagina->getText();
        $linhas = array_values(array_filter(explode("\n", $textoPagina)));

        for ($i = 0; $i < count($linhas) - 1; $i += 2) {
            $linhaProduto = $linhas[$i];
            $linhaValor = $linhas[$i + 1];

            $ref = $this->model->extrairReferencia($linhaProduto);
            $produto = $this->model->extrairProduto($linhaProduto);
            $valor = $this->model->extrairValor($linhaValor);

            if ($ref && $produto && $valor) {
                $produtos[] = [
                    'referencia' => $ref,
                    'produto' => $produto,
                    'valor' => $valor,
                    'multiplicador' => $marcador,
                    'valor_venda' => $valor * $marcador
                ];
            }
        }
    }

    // Gerar PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('Accord Iluminação'), 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, utf8_decode('Referência'), 1);
    $pdf->Cell(120, 10, 'Produto', 1);
    $pdf->Cell(30, 10, 'Valor de Venda', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    foreach ($produtos as $item) {
        $valorFormatado = 'R$ ' . number_format($item['valor_venda'], 2, ',', '.');
        $pdf->Cell(30, 8, $item['referencia'], 1);
        $pdf->Cell(120, 8, utf8_decode($item['produto']), 1);
        $pdf->Cell(30, 8, $valorFormatado, 1);
        $pdf->Ln();
    }

    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output();
    }, 'produtos_accord_iluminacao.pdf');
}



    public function show(Item $item)
    {
        return $item;
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'referencia' => 'sometimes|string',
            'produto' => 'sometimes|string',
            'valor' => 'sometimes|numeric',
            'valor_venda' => 'sometimes|numeric',
            'multiplicador' => 'sometimes|numeric',
        ]);

        $item->update($validated);

        return $item;
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->noContent();
    }
}
