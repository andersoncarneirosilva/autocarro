<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outorgado;
use App\Models\ModeloProcuracoes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class OutorgadoController extends Controller
{
    protected $model;

    public function __construct(Outorgado $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja tests excluir esse outorgado?";
        confirmDelete($title, $text);

        $userId = Auth::id();
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
    $userId = Auth::id();

    // Validação dos dados
    if (empty($request->nome_outorgado)) {
        alert()->error('O campo outorgado é obrigatório')
            ->persistent(true)
            ->autoClose(5000) // Fecha automaticamente após 5 segundos
            ->timerProgressBar();
        
        return redirect()->route('configuracoes.index');
    }elseif (empty($request->end_outorgado)) {
        alert()->error('O campo endereço é obrigatório')
        ->persistent(true)
        ->autoClose(5000) // Fecha automaticamente após 5 segundos
        ->timerProgressBar();
    
        return redirect()->route('configuracoes.index');
    }elseif (empty($request->email_outorgado)) {
        alert()->error('O campo email é obrigatório')
        ->persistent(true)
        ->autoClose(5000) // Fecha automaticamente após 5 segundos
        ->timerProgressBar();
    
        return redirect()->route('outorgados.index');
    }
    
    try {
        $validated = $request->validate([
            'nome_outorgado' => 'required|string|max:255',
            'cpf_outorgado' => 'required|string|size:11|unique:outorgados,cpf_outorgado',
            'end_outorgado' => 'required|string|max:255',
            'email_outorgado' => 'required|email|unique:outorgados,email_outorgado',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser um texto válido.',
            'max' => [
                'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
            ],
            'size' => [
                'string' => 'O campo :attribute deve ter exatamente :size caracteres.',
            ],
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'unique' => 'O campo :attribute já está em uso.',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $errorMessages = implode(', ', $e->validator->errors()->all());
        alert()->error('Erro!', $errorMessages);

    // Redireciona para a página de listagem
    return redirect()->route('outorgados.index');
    }

    // Adiciona o user_id nos dados validados
    $validated['user_id'] = $userId;

    // Salva o novo outorgado na tabela
    $this->model->create($validated);

    // Alerta de sucesso
    alert()->success('Outorgado cadastrado com sucesso!');

    // Redireciona para a página de listagem
    return redirect()->route('outorgados.index');
}



     

     public function destroy($id){
        if(!$docs = $this->model->find($id)){
            alert()->error('Erro ao excluír o pagamento!');
        }
    
        if($docs->delete()){
            alert()->success('Outorgado excluído com sucesso!');
        }

        return redirect()->route('outorgados.index');
    }

}
