<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;
use App\Models\Outorgado;
use App\Models\ModeloProcuracoes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ConfiguracoesController extends Controller
{
    protected $model;

    public function __construct(Configuracao $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request)
{
    $title = 'Excluir!';
    $text = "Tem certeza que deseja excluir?";
    confirmDelete($title, $text);

    $userId = Auth::id();
    $user = User::find($userId);

    $assinatura = $user->assinaturas()->latest()->first();

        if(!$user->plano == "Teste" || !$user->plano == "Premium"){
            if (!$assinatura || now()->gt($assinatura->data_fim) || $assinatura->status == "pending") {
                return redirect()->route('assinatura.expirada')->with('error', 'Sua assinatura expirou.');
            }
        }
    //dd($user);
    // Paginar os registros de Outorgado
    $outorgados = Outorgado::where('user_id', $userId)->get();
    
    // Filtrar os registros de ModeloProcuracoes pelo user_id do usuário logado
    $modeloProc = ModeloProcuracoes::where('user_id', $userId)->get()->map(function ($modelo) {
        // Decodificar o campo "outorgados" (JSON)
        $outorgadosIds = json_decode($modelo->outorgados, true);

        // Buscar os registros de "outorgados" relacionados
        $modelo->outorgadosDetalhes = Outorgado::whereIn('id', $outorgadosIds)->get();

        return $modelo;
    });


    // Passa os dados necessários para a view
    return view('configuracoes.index', compact('modeloProc', 'outorgados'));
}


public function storeOrUpdate(Request $request)
{
    // Obtém o ID do usuário logado
    $userId = Auth::id();

    // Obtém os textos necessários
    $textoInicio = TextoInicio::first();
    $textoPoder = TextoPoder::first();
    $cidade = Cidade::first();

    // Verifica se o campo "outorgados" foi enviado e é um array
    if ($request->has('outorgados') && is_array($request->outorgados)) {
        // Salva o array de outorgados como JSON
        $outorgadosJson = json_encode($request->outorgados);

        // Verifica se já existe um cadastro na tabela
        $existeCadastro = ModeloProcuracoes::first();

        if ($existeCadastro) {
            // Atualiza o registro existente
            $existeCadastro->update([
                'outorgados' => $outorgadosJson,
                'texto_inicial' => $textoInicio->texto_inicio, // Salva texto_inicial como string
                'texto_final' => $textoPoder->texto_final,    // Salva texto_final como string
                'user_id' => $userId,           // Salva o ID do usuário logado
                'cidade' => $cidade->cidade,
            ]);
        } else {
            // Cria um novo registro
            ModeloProcuracoes::create([
                'outorgados' => $outorgadosJson,
                'texto_inicial' => $textoInicio ? $textoInicio->texto_inicio : null,
                'texto_final' => $textoPoder ? $textoPoder->texto_final : null,
                'user_id' => $userId,
                'cidade' => $cidade ? $cidade->cidade : null,
            ]);
        }
    } else {
        // Retorna erro caso 'outorgados' não seja enviado ou não seja um array
        return redirect()->back()->withErrors(['outorgados' => 'O campo outorgados é obrigatório e deve ser um array.']);
    }

    // Redireciona com mensagem de sucesso
    alert()->success('Outorgado selecionado com sucesso!');

        return redirect()->route('configuracoes.index');
}
   

    // public function update(Request $request, $id){
    //     $doc = ConfigProc::findOrFail($id);
    
    //     $doc->update($request->all());
    
    //     alert()->success('Procuração editada com sucesso!');
    //     return redirect()->route('configuracoes.index');
    // }

    // public function show($id){
    //     $configuracao = ConfigProc::find($id);

    //     if (!$configuracao) {
    //         return response()->json(['error' => 'Configuração não encontrada'], 404);
    //     }

    //     return response()->json($configuracao);
    // }

}
