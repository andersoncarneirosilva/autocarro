<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ordem;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\Procuracao; // Certifique-se de que o Model existe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatoriosController extends Controller
{
    // Método auxiliar para centralizar a lógica de Empresa
    private function getEmpresaId()
    {
        return Auth::user()->empresa_id ?? Auth::id();
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $assinatura = $user->assinaturas()->latest()->first();

        // Lógica de assinatura (Mantida conforme original)
        if ($user->plano == 'Padrão' || $user->plano == 'Pro') {
            if (!$assinatura || now()->gt($assinatura->data_fim) || $assinatura->status == 'pending') {
                return redirect()->route('assinatura.expirada')->with('error', 'Sua assinatura expirou.');
            }
        }

        return view('relatorios.index');
    }

    public function gerarRelatoriosSelect(Request $request)
    {
        $empresaId = $this->getEmpresaId();

        $validated = $request->validate([
            'tipo-relatorio' => 'required|string',
            'data-inicial' => 'required|date',
            'data-final' => 'required|date|after_or_equal:data-inicial',
        ]);

        $tipo = $validated['tipo-relatorio'];
        $dataInicial = $validated['data-inicial'];
        $dataFinal = $validated['data-final'];

        $intervalo = [$dataInicial . ' 00:00:00', $dataFinal . ' 23:59:59'];

        switch ($tipo) {
            case 'Clientes':
                $dados = Cliente::where('empresa_id', $empresaId)
                    ->whereBetween('created_at', $intervalo)
                    ->get();
                return view('relatorios.resultado-clientes', compact('dados', 'tipo', 'dataInicial', 'dataFinal'));

            case 'Veículos':
                $dados = Veiculo::where('empresa_id', $empresaId)
                    ->whereBetween('created_at', $intervalo)
                    ->get();
                return view('relatorios.resultado-veiculos', compact('dados', 'tipo', 'dataInicial', 'dataFinal'));

            default:
                return back()->withErrors(['tipo-relatorio' => 'Tipo de relatório inválido.']);
        }
    }

    public function gerarPdfClientes(Request $request)
    {
        $empresaId = $this->getEmpresaId();
        $dataI = $request['dataInicial'];
        $dataF = $request['dataFinal'];

        $dados = Cliente::where('empresa_id', $empresaId)
            ->whereBetween('created_at', [$dataI . ' 00:00:00', $dataF . ' 23:59:59'])
            ->get();

        return $this->gerarPdf('relatorios.rel-clientes', compact('dados', 'dataI', 'dataF'), 'relatorio_clientes.pdf');
    }

    public function gerarPdfVeiculos(Request $request)
    {
        $empresaId = $this->getEmpresaId();
        $dataInicial = $request->input('dataInicial');
        $dataFinal = $request->input('dataFinal');

        $dados = Veiculo::where('empresa_id', $empresaId)
            ->whereBetween('created_at', [$dataInicial . ' 00:00:00', $dataFinal . ' 23:59:59'])
            ->get();

        return $this->gerarPdf('relatorios.veiculos', compact('dados', 'dataInicial', 'dataFinal'), 'relatorio_veiculos.pdf');
    }

    // Métodos sem filtro de data também precisam de trava de segurança (empresa_id)
    public function gerarRelatorioClientes()
    {
        $dados = Cliente::where('empresa_id', $this->getEmpresaId())->get();
        return $this->gerarPdf('relatorios.clientes', compact('dados'), 'relatorio_clientes.pdf');
    }

    public function gerarRelatorioVeiculos()
    {
        $dados = Veiculo::where('empresa_id', $this->getEmpresaId())->get();
        return $this->gerarPdf('relatorios.veiculos', compact('dados'), 'relatorio_veiculos.pdf');
    }

    /**
     * Helper para evitar repetição de código DomPDF
     */
    private function gerarPdf($viewPath, $data, $filename)
    {
        $view = view($viewPath, $data)->render();
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a4', 'landscape');
        return $pdf->stream($filename);
    }
}