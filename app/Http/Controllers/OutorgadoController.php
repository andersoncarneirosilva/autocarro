<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outorgado;
use App\Models\User;
use App\Models\ModeloProcuracoes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OutorgadoController extends Controller
{
    protected $model;

    public function __construct(Outorgado $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse outorgado?";
        confirmDelete($title, $text);

        $userId = Auth::id();
    $user = User::find($userId);

    $assinatura = $user->assinaturas()->latest()->first();

    if($user->plano == "Padrão" || $user->plano == "Pro"){
        if (!$assinatura || now()->gt($assinatura->data_fim) || $assinatura->status == "pending") {
            return redirect()->route('assinatura.expirada')->with('error', 'Sua assinatura expirou.');
        }
    }
        $outs = $this->model->getSearch($request->search, $userId);

        return view('outorgados.index', compact('outs'));

    }

    public function update(Request $request, $id)
{
    //dd($request);
    // Verifica se o campo nome_outorgado está vazio
    if (empty($request->nome_outorgado)) {
        alert()->error('O campo outorgado é obrigatório')
            ->persistent(true)
            ->autoClose(3000) // Fecha automaticamente após 3 segundos
            ->timerProgressBar();
        
        return redirect()->route('outorgados.index');
    }
    if (empty($request->cpf_outorgado)) {
        alert()->error('O campo cpf é obrigatório')
            ->persistent(true)
            ->autoClose(3000) // Fecha automaticamente após 3 segundos
            ->timerProgressBar();
        
        return redirect()->route('outorgados.index');
    }
    if (empty($request->end_outorgado)) {
        alert()->error('O campo endereço é obrigatório')
            ->persistent(true)
            ->autoClose(3000) // Fecha automaticamente após 3 segundos
            ->timerProgressBar();
        
        return redirect()->route('outorgados.index');
    }
    if (empty($request->email_outorgado)) {
        alert()->error('O campo email é obrigatório')
            ->persistent(true)
            ->autoClose(3000) // Fecha automaticamente após 3 segundos
            ->timerProgressBar();
        
        return redirect()->route('outorgados.index');
    }

    // Validação dos dados do formulário
    $validated = $request->validate([
        'nome_outorgado' => 'required|string|max:255',
        'cpf_outorgado' => 'required|string|max:14',
        'end_outorgado' => 'required|string|max:255',
        'email_outorgado' => 'required|email|max:255', // Validar o email
    ]);

    // Recupera o modelo Outorgado a ser atualizado
    $outorgado = Outorgado::find($id);

    // Verifica se o Outorgado existe
    if (!$outorgado) {
        alert()->error('Outorgado não encontrado')
            ->persistent(true)
            ->autoClose(3000)
            ->timerProgressBar();
        
        return redirect()->route('outorgados.index');
    }

    // Atualiza os dados do Outorgado
    $outorgado->update($validated);

    // Alerta de sucesso
    alert()->success('Outorgado atualizado com sucesso')
        ->persistent(true)
        ->autoClose(3000)
        ->timerProgressBar();

    // Redireciona para a página de listagem
    return redirect()->route('outorgados.index');
}




    public function show($id){
        $configuracao = Outorgado::find($id);
        
        if (!$configuracao) {
            return response()->json(['error' => 'Configuração não encontrada'], 404);
        }

        return response()->json($configuracao);
    }

    public function store(Request $request)
{
    $request->validate([
        'nome_outorgado'  => 'required|string|max:255',
        'end_outorgado'   => 'required|string|max:255',
        'email_outorgado' => [
            'required',
            'email',
            'max:255',
            Rule::unique('outorgados', 'email_outorgado')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            }),
        ],
        'cpf_outorgado'   => [
            'required',
            'string',
            Rule::unique('outorgados', 'cpf_outorgado')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            }),
        ],
    ], [
        'nome_outorgado.required'  => 'O campo outorgado é obrigatório.',
        'end_outorgado.required'   => 'O campo endereço é obrigatório.',
        'email_outorgado.required' => 'O campo e-mail é obrigatório.',
        'email_outorgado.email'    => 'O e-mail informado não é válido.',
        'email_outorgado.unique'   => 'O e-mail informado já está cadastrado para este usuário.',
        'cpf_outorgado.required'   => 'O campo CPF é obrigatório.',
        'cpf_outorgado.unique'     => 'O CPF informado já está cadastrado para este usuário.',
    ]);
    

    // Adiciona o user_id aos dados
    $data = $request->all();
    $data['user_id'] = Auth::id();

    // Salva no banco de dados
    $this->model->create($data);

    alert()->success('Outorgado cadastrado com sucesso')
        ->persistent(true)
        ->autoClose(3000)
        ->timerProgressBar();

    // Redireciona para a página de listagem
    return redirect()->route('outorgados.index');
}






     

public function destroy($id)
{
    // Verifica se o Outorgado existe
    if (!$docs = $this->model->find($id)) {
        alert()->error('Erro ao excluir o Outorgado!');
        return redirect()->route('outorgados.index');
    }

    // Busca todos os registros que contenham esse outorgado na tabela modeloprocuracoes
    $procuracoes = ModeloProcuracoes::whereJsonContains('outorgados', (string) $id)->get();

    foreach ($procuracoes as $procuracao) {
        // Decodifica o array JSON
        $outorgados = json_decode($procuracao->outorgados, true);

        // Remove o ID do outorgado da lista
        $outorgados = array_diff($outorgados, [(string) $id]);

        if (empty($outorgados)) {
            // Se não houver mais outorgados, excluir a modeloprocuracao
            $procuracao->delete();
        } else {
            // Atualiza a coluna outorgados sem o ID removido
            $procuracao->outorgados = json_encode(array_values($outorgados));
            $procuracao->save();
        }
    }

    // Exclui o Outorgado
    if ($docs->delete()) {
        alert()->success('Outorgado excluído com sucesso!');
    }

    return redirect()->route('outorgados.index');
}


}
