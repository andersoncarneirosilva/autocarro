<?php

namespace App\Http\Controllers;

use App\Models\ModeloProcuracao;
use App\Models\Outorgado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ModeloProcuracaoController extends Controller
{
    protected $model;

    public function __construct(ModeloProcuracao $procs)
    {
        $this->model = $procs;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        // Mudamos para get() ou paginate se quiser listar, 
        // mas como é configuração, o first() costuma ser o modelo global do user
        $modeloProc = $this->model::where('user_id', $userId)->get(); 

        // Coletar outorgados para o select do modal
        $outorgados = Outorgado::where('user_id', $userId)->get();

        return view('configuracoes.index', compact('modeloProc', 'outorgados'));
    }

    public function store(Request $request)
    {
        dd($request);
        try {
            // Validação unificada
            $request->validate([
                'conteudo' => 'required|string', // Agora salvamos apenas o conteúdo único
                'cidade' => 'required|string',
                'outorgados' => 'required|array|min:1|max:3',
                'outorgados.*' => 'exists:outorgados,id',
            ]);

            // Busca ou Cria o modelo do usuário (Alcecar padrão: 1 modelo por lojista)
            $modelo = ModeloProcuracao::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'conteudo'   => $request->conteudo, // Salva o HTML do CKEditor
                    'cidade'     => $request->cidade,
                    'outorgados' => json_encode($request->outorgados), // IDs selecionados
                ]
            );

            Log::info('Modelo de procuração Alcecar processado:', $modelo->toArray());
            alert()->success('Procuração salva com sucesso!');

            return redirect()->route('configuracoes.index');

        } catch (\Exception $e) {
            Log::error('Erro ao salvar no Alcecar:', ['msg' => $e->getMessage()]);
            alert()->error('Erro', 'Não foi possível salvar os dados.');
            return redirect()->back();
        }
    }

    public function show($id)
{
    $modelo = ModeloProcuracao::find($id);
    return response()->json([
        'success' => true,
        'data' => [
            'conteudo' => $modelo->conteudo, // CERTIFIQUE-SE QUE ESTE NOME ESTÁ CORRETO
            'cidade'   => $modelo->cidade,
            'outorgados' => $modelo->outorgados
        ]
    ]);
}
}