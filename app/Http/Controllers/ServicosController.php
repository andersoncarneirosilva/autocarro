<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;

class ServicosController extends Controller
{
    protected $model;

    public function __construct(Servico $serv)
    {
        $this->model = $serv;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse serviço?";
        confirmDelete($title, $text);

        $servs = Servico::paginate(10);
        //dd($servs);
        return view('servicos.index', compact('servs'));
    }

    // public function create(){
    //     return view('subcategory.create');
    // }

    public function store(Request $request){
        
        try {
            $validated = $request->validate([
                'nome_servico' => 'required|string|max:255',
                'valor_servico' => 'required|numeric|min:0',
                'taxa_servico' => 'required|numeric|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            alert()->error('Todos os campos são obrigatórios!');
            return redirect()->route('servicos.index');
        }
    
        if ($this->model->create($validated)) {
            alert()->success('Serviço cadastrado com sucesso!');
            return redirect()->route('servicos.index');
        }
    
        alert()->error('Erro ao cadastrar o serviço!');
        return redirect()->route('servicos.index');
    }
    

    public function destroy($id){
        if(!$doc = $this->model->find($id)){
            alert()->error('Erro ao excluír o serviço!');
        }
       
        if($doc->delete()){
            alert()->success('Serviço excluído com sucesso!');
        }
         return redirect()->route('servicos.index');
    }
}
