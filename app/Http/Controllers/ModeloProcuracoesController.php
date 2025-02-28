<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModeloProcuracoes;
use Illuminate\Support\Facades\Auth;
use App\Models\Outorgado;
use Illuminate\Support\Facades\Log;

class ModeloProcuracoesController extends Controller
{
    //
    protected $model;

    public function __construct(ModeloProcuracoes $procs)
    {
        $this->model = $procs;
    }


public function index(Request $request)
{
    $title = 'Excluir!';
    $text = "Deseja excluir essa categoria?";
    confirmDelete($title, $text);

    // Obter o ID do usuário logado
    $userId = Auth::id();
//dd($userId);
    // Buscar o modelo de procuração relacionado ao usuário logado
    $modeloProc = $this->model::where('user_id', $userId)->first();

    // Retornar para a view
    return view('configuracoes.index', compact('modeloProc'));
}


public function store(Request $request)
{
    try {
        // Verificar se o número de outorgados excede o limite
        if (!is_array($request->outorgados) || count($request->outorgados) > 3 || count($request->outorgados) < 1) {
            alert()->error('Erro!', 'Selecione ao menos 1 e no máximo 3 outorgados.')
                ->persistent(true)
                ->autoClose(5000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();
            
            return redirect()->route('configuracoes.index');
        }
        
        $request->validate([
            'texto_inicial' => 'required|string',
            'texto_final' => 'required|string',
            'cidade' => 'required|string',
            'outorgados' => 'required|array|max:3',  // A validação do Laravel já garante que o limite não será ultrapassado
            'outorgados.*' => 'exists:outorgados,id',
        ]);

        // Critérios para verificar a existência do registro
        $modelo = ModeloProcuracoes::where('user_id', auth()->id())->first();

        if ($modelo) {
            // Atualizar o registro existente
            $modelo->update([
                'texto_inicial' => $request->texto_inicial,
                'texto_final' => $request->texto_final,
                'cidade' => $request->cidade,
                'outorgados' => json_encode($request->outorgados),
            ]);

            Log::info('Modelo de procuração atualizado com sucesso:', $modelo->toArray());
            alert()->success('Procuração atualizada com sucesso!');
        } else {
            // Criar um novo registro
            $modelo = ModeloProcuracoes::create([
                'texto_inicial' => $request->texto_inicial,
                'texto_final' => $request->texto_final,
                'cidade' => $request->cidade,
                'user_id' => auth()->id(),
                'outorgados' => json_encode($request->outorgados),
            ]);

            Log::info('Modelo de procuração criado com sucesso:', $modelo->toArray());
            alert()->success('Procuração cadastrada com sucesso!');
        }

        return redirect()->route('configuracoes.index');
    } catch (\Exception $e) {
        Log::error('Erro ao salvar modelo de procuração:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        alert()->error('Erro', 'Erro ao salvar os dados: ' . $e->getMessage());
        return redirect()->back()->withErrors('Erro ao salvar os dados: ' . $e->getMessage());
    }
}





public function update(Request $request, $id)
{
    if (count($request->outorgados) < 1) {
        alert()->error('Erro!', 'Selecione ao menos 1 outorgado.')
            ->persistent(true)
            ->autoClose(5000) // Fecha automaticamente após 5 segundos
            ->timerProgressBar();
            return redirect()->route('configuracoes.index');
    }

    // Valide os dados, se necessário
    $validated = $request->validate([
        'texto_inicio' => 'required',
        // Adicione mais campos conforme necessário
    ]);

    // Encontre o registro no banco de dados
    $configuracao = ModeloProcuracoes::first();

    // Verifique se o registro foi encontrado
    if (!$configuracao) {
        return redirect()->route('configuracoes.index')->with('error', 'Configuração não encontrada.');
    }

    // Atualize os campos do modelo
    $configuracao->update($validated); // Ou passe os dados diretamente com $request->all() se não usar validação

    // Alerta de sucesso
    alert()->success('Texto editado com sucesso!');
    
    // Redireciona após a atualização
    return redirect()->route('configuracoes.index');
}


public function show($id)
{
    $modelo = ModeloProcuracoes::findOrFail($id);

    // Decodificar os IDs dos outorgados
    $outorgadosIds = json_decode($modelo->outorgados, true);

    // Buscar os detalhes dos outorgados
    $outorgadosDetalhes = Outorgado::whereIn('id', $outorgadosIds)->get();

    return response()->json([
        'success' => true,
        'data' => [
            'texto_inicial' => $modelo->texto_inicial,
            'texto_final' => $modelo->texto_final,
            'cidade' => $modelo->cidade,
            'outorgados' => $outorgadosDetalhes, // Enviar os detalhes dos outorgados
        ],
    ]);
}





}
