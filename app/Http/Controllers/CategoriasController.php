<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatDoc;
use App\Models\User;
class CategoriasController extends Controller
{
    protected $model;

    public function __construct(CatDoc $cats)
    {
        $this->model = $cats;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir essa categoria?";
        confirmDelete($title, $text);

        $cats = CatDoc::all();
        //dd($cats);
        return view('category.index', compact('cats'));
    }

    public function create(){
        return view('category.create');
    }

    public function store(Request $request){
        $data = $request->all();
        //dd($data);
        if($this->model->create($data)){
            alert()->success('Categoria cadastrada com sucesso!');

            return redirect()->route('category.index');
        }   
    }

    public function edit($id){
        if(!$cats = $this->model->find($id)){
            return redirect()->route('category.index');
        }
        return view('category.edit', compact('cats'));
    }

    public function update(Request $request, $id){
        //dd($request);
        //dd($data);
        $data = $request->all();
        if(!$cats = $this->model->find($id))
            return redirect()->route('category.index');

        if($cats->update($data)){
            alert()->success('Categoria editada com sucesso!');
            return redirect()->route('category.index');
        }
    }

    public function destroy($id){
        if(!$doc = $this->model->find($id)){
            alert()->error('Erro ao excluír o pagamento!');
        }
        
        if($doc->delete()){
            alert()->success('Categoria excluída com sucesso!');
        }

        return redirect()->route('category.index');
    }
}
