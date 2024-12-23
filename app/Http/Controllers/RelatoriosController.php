<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Procuracao;

class RelatoriosController extends Controller
{

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse veículo?";
        confirmDelete($title, $text);

        return view('relatorios.index');
    }

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

    public function gerarRelatoriosSelect(Request $request)
    {
        // Validação dos campos
        $validated = $request->validate([
            'tipo-relatorio' => 'required|string',
            'data-inicial' => 'required|date',
            'data-final' => 'required|date|after_or_equal:data-inicial',
        ]);

        $tipo = $validated['tipo-relatorio'];
        $dataInicial = $validated['data-inicial'];
        $dataFinal = $validated['data-final'];

        // Lógica para gerar o relatório com base no tipo e intervalo de datas
        switch ($tipo) {
            case 'Clientes':
                $dados = Cliente::whereBetween('created_at', [$dataInicial, $dataFinal])->get();
                //dd($dados);
                return view('relatorios.resultado-clientes', compact('dados', 'tipo', 'dataInicial', 'dataFinal'));
                break;
            case 'Procurações':
                $dados = Procuracao::whereBetween('created_at', [$dataInicial, $dataFinal])->get();
                return view('relatorios.resultado-procs', compact('dados', 'tipo', 'dataInicial', 'dataFinal'));
                break;
            case 'Veículos':
                $dados = Documento::whereBetween('created_at', [$dataInicial, $dataFinal])->get();
                break;
            default:
                return back()->withErrors(['tipo-relatorio' => 'Tipo de relatório inválido.']);
        }      
    }

    public function gerarPdf(Request $request){

        $data = $request->all();
        //dd($data);
        $dataI = $request['dataInicial'];
        $dataF = $request['dataFinal'];

        $dados = Cliente::whereBetween('created_at', [$dataI, $dataF])->get();

        $view = view('relatorios.clientes', compact('dados'))->render();
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

    public function gerarRelatorioProc()
    {
        // Obtém os dados dos clientes do banco de dados
        $procs = Procuracao::all();

        // Renderiza a view com os dados
        //$pdf = PDF::loadView('relatorios.clientes', compact('clientes'));

        $view = view('relatorios.procuracoes', compact('procs'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_procuracoes.pdf');
    }
}
