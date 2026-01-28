<?php

namespace App\Http\Controllers;

use App\Models\ModeloProcuracao;
use App\Models\ModeloAtpve;
use App\Models\Outorgado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;
        
        // Dados para a View filtrados pela EMPRESA
        $modeloProc = ModeloProcuracao::where('empresa_id', $empresaId)->get();
        $outorgados = Outorgado::where('empresa_id', $empresaId)->get();

        return view('configuracoes.index', compact('modeloProc', 'outorgados'));
    }

    public function indexAtpve()
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        $modeloAtpve = ModeloAtpve::where('empresa_id', $empresaId)->first();
        $outorgados = Outorgado::where('empresa_id', $empresaId)->get();
        
        return view('configuracoes.solicitacoes', compact('modeloAtpve', 'outorgados'));
    }

    public function saveProcuracao(Request $request)
    {
        try {
            $user = Auth::user();
            $empresaId = $user->empresa_id ?? $user->id;

            $request->validate([
                'conteudo' => 'required|string',
                'cidade' => 'required|string',
                'outorgados' => 'required|array|min:1|max:3',
                'outorgados.*' => 'exists:outorgados,id',
            ]);

            // LÓGICA ALCECAR: A busca do updateOrCreate agora é por EMPRESA_ID
            $modelo = ModeloProcuracao::updateOrCreate(
                ['empresa_id' => $empresaId], 
                [
                    'user_id'    => $user->id, // Quem salvou por último
                    'conteudo'   => $request->conteudo,
                    'cidade'     => $request->cidade,
                    'outorgados' => $request->outorgados,
                ]
            );

            return redirect()->route('configuracoes.index')
                ->with('success', 'Configuração salva com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao salvar configuração Alcecar:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Não foi possível salvar as alterações.');
        }
    }

    public function showProcuracao($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();

        // Garante que só visualiza modelos da própria empresa
        $modelo = ModeloProcuracao::where('empresa_id', $empresaId)->findOrFail($id);
        
        $ids = is_array($modelo->outorgados) 
               ? $modelo->outorgados 
               : json_decode($modelo->outorgados, true) ?? [];

        $detalhesOutorgados = Outorgado::whereIn('id', $ids)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'conteudo' => $modelo->conteudo,
                'cidade' => $modelo->cidade,
                'outorgados' => $detalhesOutorgados
            ]
        ]);
    }

    public function deleteProcuracao($id)
    {
        try {
            $empresaId = Auth::user()->empresa_id ?? Auth::id();
            $modelo = ModeloProcuracao::where('empresa_id', $empresaId)->findOrFail($id);
            $modelo->delete();

            return redirect()->route('configuracoes.index')->with('success', 'O modelo foi removido.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir.');
        }
    }

    public function saveAtpve(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        $request->validate([
            'conteudo' => 'required',
            'cidade' => 'required'
        ]);

        // Salva ou atualiza o modelo da EMPRESA
        ModeloAtpve::updateOrCreate(
            ['empresa_id' => $empresaId],
            [
                'user_id' => $user->id,
                'conteudo' => $request->conteudo,
                'cidade' => $request->cidade
            ]
        );

        return back()->with('success', 'Modelo de Solicitação ATPVe atualizado com sucesso!');
    }
}