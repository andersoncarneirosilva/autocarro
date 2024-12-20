<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Cliente;
use App\Models\Documento;

class RelatoriosController extends Controller
{
    /**
     * Gera um relatório simples de clientes em PDF.
     */
    public function gerarRelatorioClientes()
    {
        // Obtém os dados dos clientes do banco de dados
        $clientes = Cliente::all();

        // Renderiza a view com os dados
        //$pdf = PDF::loadView('relatorios.clientes', compact('clientes'));

        $view = view('relatorios.clientes', compact('clientes'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_clientes.pdf');
    }

    public function gerarRelatorioVeiculos()
    {
        // Obtém os dados dos clientes do banco de dados
        $veiculos = Documento::all();

        // Renderiza a view com os dados
        //$pdf = PDF::loadView('relatorios.clientes', compact('clientes'));

        $view = view('relatorios.veiculos', compact('veiculos'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_veiculos.pdf');
    }
}
