<?php

namespace App\Http\Controllers;
use App\Services\PdfGenerator;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Smalot\PdfParser\Parser;
use FPDF;
class RelatoriosController extends Controller
{
    //
    protected $model;

    public function __construct(Cliente $user)
    {
        $this->model = $user;
    }

    public function index()
    {
        $clientes = Cliente::all();
        return view('relatorios.index', compact('clientes'));
    }

    public function exportarPdf()
{
    $clientes = Cliente::all();
//dd($clientes);
    // Instância do PDF com formato paisagem
    $pdf = new PdfGenerator();
    $pdf->AddPage('L');
    //$pdf->SetFont('Arial', '', 12);

    // Cabeçalhos da tabela
$pdf->SetFont('Arial', 'B', 10); // Defina a fonte do cabeçalho
$pdf->Cell(15, 10, '#', 1, 0, 'C');
$pdf->Cell(80, 10, 'Nome', 1, 0, 'C');
$pdf->Cell(50, 10, 'CPF', 1, 0, 'C');
$pdf->Cell(40, 10, 'Whatsapp', 1, 0, 'C');
$pdf->Cell(60, 10, utf8_decode('Endereço'), 1, 1, 'C');

// Dados da tabela
$pdf->SetFont('Arial', '', 9); // Fonte para o conteúdo
foreach ($clientes as $cliente) {
    $pdf->Cell(15, 10, $cliente->id, 1, 0, 'C'); // ID
    $pdf->Cell(80, 10, utf8_decode($cliente->nome), 1, 0, 'L'); // Nome
    $pdf->Cell(50, 10, $cliente->cpf, 1, 0, 'L'); // CPF
    $pdf->Cell(40, 10, $cliente->fone, 1, 0, 'L'); // Whatsapp
    
    // Endereço com quebra de linha
    $x = $pdf->GetX(); // Posição X inicial
    $y = $pdf->GetY(); // Posição Y inicial
    $pdf->MultiCell(60, 5, utf8_decode($cliente->endereco), 1, 'L');
    $pdf->SetXY($x + 60, $y); // Move para a próxima célula na linha
    
    $pdf->Ln(); // Nova linha
}

    // Retorna o PDF para download
    $pdf->Output('I', 'relatorio_clientes.pdf');
}



}
