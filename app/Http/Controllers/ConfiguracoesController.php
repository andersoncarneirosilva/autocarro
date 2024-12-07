<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;
use App\Models\ConfigProc;
use App\Models\Outorgado;
use App\Models\Testemunha;

class ConfiguracoesController extends Controller
{
    protected $model;

    public function __construct(Configuracao $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse outorgado?";
        confirmDelete($title, $text);

        $procs = ConfigProc::paginate(10);
        $outs = Outorgado::paginate(10);
        $teste = Testemunha::paginate(10);
        //dd($outs);
        return view('configuracoes.index', compact(['procs', 'outs', 'teste']));
    }

    public function update(Request $request, $id){
        $doc = ConfigProc::findOrFail($id);
    
        $doc->update($request->all());
    
        alert()->success('Procuração editada com sucesso!');
        return redirect()->route('configuracoes.index');
    }

    public function show($id){
    $configuracao = ConfigProc::find($id);

    if (!$configuracao) {
        return response()->json(['error' => 'Configuração não encontrada'], 404);
    }

    return response()->json($configuracao);
}

    // public function create(){
    //     return view('category.create');
    // }

    // public function store(Request $request){
    //     $data = $request->all();
    //     //dd($data);
    //     if($this->model->create($data)){
    //         alert()->success('Categoria cadastrada com sucesso!');

    //         return redirect()->route('category.index');
    //     }   
    // }

    // public function edit($id){
    //     if(!$cats = $this->model->find($id)){
    //         return redirect()->route('category.index');
    //     }
    //     return view('category.edit', compact('cats'));
    // }

    // public function update(Request $request, $id){
    //     //dd($request);
    //     //dd($data);
    //     $data = $request->all();
    //     if(!$cats = $this->model->find($id))
    //         return redirect()->route('category.index');

    //     if($cats->update($data)){
    //         alert()->success('Categoria editada com sucesso!');
    //         return redirect()->route('category.index');
    //     }
    // }

    // public function destroy($id){
    //     if(!$doc = $this->model->find($id)){
    //         alert()->error('Erro ao excluír o pagamento!');
    //     }
        
    //     if($doc->delete()){
    //         alert()->success('Categoria excluída com sucesso!');
    //     }

    //     return redirect()->route('category.index');
    // }
}
