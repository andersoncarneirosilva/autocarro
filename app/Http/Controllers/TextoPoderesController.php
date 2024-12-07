<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextoPoder;

class TextoPoderesController extends Controller
{
    protected $model;

    public function __construct(TextoPoder $texts)
    {
        $this->model = $texts;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir essa categoria?";
        confirmDelete($title, $text);

        $texts = TextoPoder::paginate(10);
        //dd($docs);
        return view('configuracoes.index', compact('texts'));
    }

    public function store(Request $request){
        $data = $request->all();
        //dd($data);
        if($this->model->create($data)){
            alert()->success('Texto cadastrado com sucesso!');
        }   

        return redirect()->route('configuracoes.index');
    }

    public function update(Request $request, $id){

        $doc = TextoPoder::findOrFail($id);
    
        $doc->update($request->all());
    
        alert()->success('Texto editado com sucesso!');
        return redirect()->route('configuracoes.index');
    }

    public function show($id){
        $configuracao = TextoPoder::find($id);
        
        if (!$configuracao) {
            return response()->json(['error' => 'Configuração não encontrada'], 404);
        }
    
        return response()->json($configuracao);
    }

    public function destroy($id){
        if(!$docs = $this->model->find($id)){
            alert()->error('Erro ao excluír o texto!');
        }
    
        if($docs->delete()){
            alert()->success('Texto excluído com sucesso!');
        }

        return redirect()->route('configuracoes.index');
    }
}
