<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outorgado;
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

        $procs = Outorgado::paginate(10);
        //dd($docs);
        return view('configuracoes.index', compact('procs'));
    }

    public function update(Request $request, $id){

        $doc = Outorgado::findOrFail($id);
    
        $doc->update($request->all());
    
        alert()->success('Procuração editada com sucesso!');
        return redirect()->route('configuracoes.index');
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

     public function store(Request $request){
        $data = $request->all();
        
        // Buscando o primeiro registro (se houver)
        $outorgados = Outorgado::first();

        $validator = Validator::make($request->all(), [
            'nome_outorgado' => 'required|string|max:255',
            'cpf_outorgado' => 'required|cpf|unique:outorgados,cpf_outorgado',
            'end_outorgado' => 'required|string|max:255',
        ]);
    
        // Caso a validação falhe, retorne os erros
        if ($validator->fails()) {
            alert()->error('Todos os campos são obrigatórios!');

            return redirect()->route('configuracoes.index');
        }

        // Verifica se já existe um registro de outorgado no banco de dados
        if ($outorgados) {
            // Se encontrar um registro, verifica se o nome ou CPF já estão cadastrados
            if ($outorgados->nome_outorgado == $request->nome_outorgado) {
                alert()->error('Outorgado já cadastrado!');
                return redirect()->route('configuracoes.index');
            }
            
            if ($outorgados->cpf_outorgado == $request->cpf_outorgado) {
                alert()->error('Outorgado já cadastrado!');
                return redirect()->route('configuracoes.index');
            }
        }
         //dd($data);
         if($this->model->create($data)){
             alert()->success('Outorgado cadastrado com sucesso!');
         }   

         return redirect()->route('configuracoes.index');
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
