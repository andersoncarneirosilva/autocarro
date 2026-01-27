<?php

namespace App\Http\Controllers;

use App\Models\ModeloProcuracao;
use App\Models\Outorgado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Dados para a View
        $modeloProc = ModeloProcuracao::where('user_id', $userId)->get();
        $outorgados = Outorgado::where('user_id', $userId)->get();

        return view('configuracoes.index', compact('modeloProc', 'outorgados'));
    }

   public function indexAtpve()
{
    $modeloAtpve = \App\Models\ModeloAtpve::where('user_id', auth()->id())->first();
    $outorgados = \App\Models\Outorgado::where('user_id', auth()->id())->get();
    
    // Certifique-se de que o caminho da view está correto
    return view('configuracoes.solicitacoes', compact('modeloAtpve', 'outorgados'));
}

    /**
     * Salva ou Atualiza o modelo (Create/Update)
     */
    public function saveProcuracao(Request $request)
{
    try {
        $request->validate([
            'conteudo' => 'required|string',
            'cidade' => 'required|string',
            'outorgados' => 'required|array|min:1|max:3',
            'outorgados.*' => 'exists:outorgados,id',
        ]);

        $modelo = ModeloProcuracao::updateOrCreate(
            ['user_id' => Auth::id()], 
            [
                'conteudo'   => $request->conteudo,
                'cidade'     => $request->cidade,
                'outorgados' => $request->outorgados,
            ]
        );

        // Retorna com a chave 'success' para ativar o seu script de Toast
        return redirect()->route('configuracoes.index')
            ->with('success', 'Configuração salva com sucesso!');

    } catch (\Exception $e) {
        Log::error('Erro ao salvar configuração Alcecar:', ['error' => $e->getMessage()]);
        
        // Retorna com a chave 'error' para o Toast
        return redirect()->back()
            ->with('error', 'Não foi possível salvar as alterações.');
    }
}

    /**
     * Retorna os dados para o Modal (Read)
     */
    public function showProcuracao($id)
{
    $modelo = ModeloProcuracao::where('user_id', Auth::id())->findOrFail($id);
    
    // Se o cast estiver no model, $modelo->outorgados já é um array.
    // Se não estiver, fazemos a checagem manual:
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

    /**
     * Exclui o modelo (Delete)
     */
    public function deleteProcuracao($id)
    {
        try {
            $modelo = ModeloProcuracao::where('user_id', Auth::id())->findOrFail($id);
            $modelo->delete();

            alert()->success('Excluído!', 'O modelo foi removido.');
            return redirect()->route('configuracoes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir.');
        }
    }

    public function saveAtpve(Request $request)
{
    // Validação básica
    $request->validate([
        'conteudo' => 'required',
        'cidade' => 'required'
    ]);

    // Salva ou atualiza o modelo do usuário logado
    \App\Models\ModeloAtpve::updateOrCreate(
        ['user_id' => auth()->id()],
        [
            'conteudo' => $request->conteudo,
            'cidade' => $request->cidade
        ]
    );

    return back()->with('success', 'Modelo de Solicitação ATPVe atualizado com sucesso!');
}
}