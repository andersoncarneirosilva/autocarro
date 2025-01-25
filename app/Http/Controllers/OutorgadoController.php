<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outorgado;
use App\Models\ModeloProcuracoes;
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

        $outs = Outorgado::paginate(10);
        //dd($docs);
        return view('outorgados.index', compact('outs'));
    }

    public function update(Request $request, $id){

        $doc = Outorgado::findOrFail($id);
    
        $doc->update($request->all());
    
        alert()->success('Procuração editada com sucesso!');
        return redirect()->route('outorgados.index');
    }

    public function show($id){
    $configuracao = Outorgado::find($id);
//dd($configuracao);
    if (!$configuracao) {
        return response()->json(['error' => 'Configuração não encontrada'], 404);
    }

    return response()->json($configuracao);
}

    // public function create(){
    //     return view('category.create');
    // }

    public function store(Request $request)
{
    // Validação dos dados
    $validated = $request->validate([
        'nome_outorgado' => 'required|string|max:255',
        'cpf_outorgado' => 'required|cpf|unique:outorgados', // Exemplo de validação de CPF
        'end_outorgado' => 'required|string|max:255',
    ]);

    // Dados que você já validou
    $data = $validated;

    // Salva o novo outorgado na tabela 'outorgados'
    $outorgado = $this->model->create($data);

    // Verifique se a criação do outorgado foi bem-sucedida
    if ($outorgado) {
        // Agora, salve os dados na tabela 'ModeloProcuracoes'
        
        $modeloProcuracaoData = [
            'outorgados' => json_encode([$outorgado->id]), // Adicionando o ID do outorgado como um array em JSON
            'texto_inicial' => 'Texto inicial para o modelo', // Aqui você pode ajustar conforme necessário
            'texto_final' => null, // Caso necessário, preencha com dados adicionais
            'cidade' => null, // Caso necessário, preencha com dados adicionais
            'user_id' => auth()->id(), // Defina o user_id se necessário
        ];

        // Salve na tabela ModeloProcuracoes
        ModeloProcuracoes::create($modeloProcuracaoData);

        // Alerta de sucesso
        alert()->success('Outorgado cadastrado com sucesso e dados salvos em ModeloProcuracoes!');
    } else {
        alert()->error('Erro ao cadastrar o Outorgado!');
    }

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

        return redirect()->route('configuracoes.index');
    }

}
