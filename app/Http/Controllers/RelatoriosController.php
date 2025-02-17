<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Veiculo;
use App\Models\Ordem;
use Illuminate\Support\Facades\Auth;

class RelatoriosController extends Controller
{

    public function index(Request $request){

        $userId = Auth::id();
        $user = User::find($userId);

        $assinatura = $user->assinaturas()->latest()->first();

        if($user->plano == "Padrão" || $user->plano == "Pro"){
            if (!$assinatura || now()->gt($assinatura->data_fim) || $assinatura->status == "pending") {
                return redirect()->route('assinatura.expirada')->with('error', 'Sua assinatura expirou.');
            }
        }

        $title = 'Excluir!';
        $text = "Deseja excluir esse veículo?";
        confirmDelete($title, $text);

        return view('relatorios.index');
    }

    

    public function gerarRelatoriosSelect(Request $request)
{
    $userId = Auth::id();
    
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
            // Filtra os clientes do usuário logado
            $dados = Cliente::where('user_id', $userId)
                            ->whereBetween('created_at', [
                                $dataInicial . ' 00:00:00',
                                $dataFinal . ' 23:59:59'
                            ])
                            ->get();
            return view('relatorios.resultado-clientes', compact('dados', 'tipo', 'dataInicial', 'dataFinal'));
            break;


        case 'Veículos':
            // Adiciona a restrição para o usuário logado, se necessário
            $dados = Veiculo::where('user_id', $userId)
                              ->whereBetween('created_at', [
                                  $dataInicial . ' 00:00:00',
                                  $dataFinal . ' 23:59:59'
                              ])
                              ->get();
            return view('relatorios.resultado-veiculos', compact('dados', 'tipo', 'dataInicial', 'dataFinal'));
            break;

        default:
            return back()->withErrors(['tipo-relatorio' => 'Tipo de relatório inválido.']);
    }      
}


    public function gerarPdfClientes(Request $request){

        $userId = Auth::id();

        $data = $request->all();
        //dd($data);
        $dataI = $request['dataInicial'];
        $dataF = $request['dataFinal'];

        $dados = Cliente::whereBetween('created_at', [
            $dataI . ' 00:00:00',
            $dataF . ' 23:59:59'
        ])->get();
        

        $view = view('relatorios.rel-clientes', compact('dados', 'dataI', 'dataF'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_clientes.pdf');
    }

    public function gerarPdfProcs(Request $request){

        $data = $request->all();
        //dd($data);
        $dataI = $request['dataInicial'];
        $dataF = $request['dataFinal'];

        $procs = Procuracao::whereBetween('created_at', [
            $dataI . ' 00:00:00',
            $dataF . ' 23:59:59'
        ])->get();

        $view = view('relatorios.procuracoes', compact('procs'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_procuracoes.pdf');
    }
    
    public function gerarPdfOrdens(Request $request){

        $data = $request->all();
        //dd($data);
        $dataI = $request['dataInicial'];
        $dataF = $request['dataFinal'];

        $ordem = Ordem::whereBetween('created_at', [
            $dataI . ' 00:00:00',
            $dataF . ' 23:59:59'
        ])->get();

        $view = view('relatorios.ordens', compact('ordem'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_ordens_de_servico.pdf');
    }

    public function gerarPdfVeiculos(Request $request){

        $data = $request->all();
        //dd($data);
        $dataI = $request['dataInicial'];
        $dataF = $request['dataFinal'];

        $dados = Veiculo::whereBetween('created_at', [
            $dataI . ' 00:00:00',
            $dataF . ' 23:59:59'
        ])->get();

        $view = view('relatorios.veiculos', compact('dados'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_veiculos.pdf');
    }


    public function gerarRelatorioClientes()
    {
        // Obtém os dados dos clientes do banco de dados
        $dados = Cliente::all();

        // Renderiza a view com os dados
        //$pdf = PDF::loadView('relatorios.clientes', compact('clientes'));

        $view = view('relatorios.clientes', compact('dados'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_clientes.pdf');
    }

    public function gerarRelatorioOrdens()
    {
        // Obtém os dados dos clientes do banco de dados
        //$dados = Ordem::all();
        $dados = Ordem::with('cliente')->paginate(10);
        // Renderiza a view com os dados
        //$pdf = PDF::loadView('relatorios.clientes', compact('clientes'));

        $view = view('relatorios.ordens', compact('dados'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)
        ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        return $pdf->stream('relatorio_orden_de_servico.pdf');
    }

    public function gerarRelatorioVeiculos()
    {
        // Obtém os dados dos clientes do banco de dados
        $dados = Veiculo::all();

        // Renderiza a view com os dados
        //$pdf = PDF::loadView('relatorios.clientes', compact('clientes'));

        $view = view('relatorios.veiculos', compact('dados'))->render();
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
