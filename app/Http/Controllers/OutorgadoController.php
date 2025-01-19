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

     public function store(Request $request){
        $data = $request->all();
        
        // Buscando o primeiro registro (se houver)
        $outorgados = Outorgado::first();

        

        // Verifica se já existe um registro de outorgado no banco de dados
        if ($outorgados) {
            // Se encontrar um registro, verifica se o nome ou CPF já estão cadastrados
            if ($outorgados->nome_outorgado == $request->nome_outorgado) {
                alert()->error('Outorgado já cadastrado!');
                return redirect()->route('outorgados.index');
            }
            
            if ($outorgados->cpf_outorgado == $request->cpf_outorgado) {
                alert()->error('Outorgado já cadastrado!');
                return redirect()->route('outorgados.index');
            }
        }
         //dd($data);
         if($this->model->create($data)){
             alert()->success('Outorgado cadastrado com sucesso!');
         }   

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
