<?php

namespace App\Services;

use FPDF;

class PdfGenerator extends FPDF
{
    // Cabeçalho do PDF
    function Header()
    {
        // Adiciona o logo no canto superior esquerdo
        $this->Image(public_path('images/clientes/logo.png'), 10, 6, 30); // Ajuste o caminho e tamanho conforme necessário

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Relatorio de Clientes - Paisagem', 0, 1, 'C');
        $this->Ln(15); // Ajusta o espaçamento após o cabeçalho
    }

    // Rodapé do PDF
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}
