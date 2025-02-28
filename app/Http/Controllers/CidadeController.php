<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeController extends Controller
{
    protected $model;

    public function __construct(Cidade $cidade)
    {
        $this->model = $cidade;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse item?";
        confirmDelete($title, $text);

        $cidade = Cidade::paginate(10);
        //dd($servs);
        return view('configuracoes.index', compact('cidade'));
    }

    // public function create(){
    //     return view('subcategory.create');
    // }

     public function store(Request $request){
         $data = $request->all();
         //dd($data);
         try {
            $validated = $request->validate([
                'cidade' => 'required|string|max:255',
            ]);
            //dd($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            alert()->error('Campo cidade é obrigatório!');
            return redirect()->route('configuracoes.index');
        }

         if($this->model->create($data)){
            alert()->success('Cidade cadastrada com sucesso!');

            return redirect()->route('configuracoes.index');
        }
     }

     public function show($id){
        
        $cidade = Cidade::find($id);
        
        if (!$cidade) {
            return response()->json(['error' => 'Configuração não encontrada'], 404);
        }
    
        return response()->json($cidade);
    }

     public function update(Request $request, $id){

        $doc = Cidade::findOrFail($id);
    
        $doc->update($request->all());
    
        alert()->success('Cidade editada com sucesso!');
        return redirect()->route('configuracoes.index');
    }

    public function destroy($id){
        if(!$doc = $this->model->find($id)){
            alert()->error('Erro ao excluír o serviço!');
        }
       
        if($doc->delete()){
            alert()->success('Cidade excluída com sucesso!');
        }
         return redirect()->route('configuracoes.index');
    }
}
