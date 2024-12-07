<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outorgado;

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
