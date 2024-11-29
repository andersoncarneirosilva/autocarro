<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCatDoc;
use App\Models\CatDoc;
class SubCatController extends Controller
{
    protected $model;

    public function __construct(SubCatDoc $subs)
    {
        $this->model = $subs;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir essa subcategoria?";
        confirmDelete($title, $text);

        $subs = SubCatDoc::all();
        $cats = CatDoc::all();
        //dd($cats);
        return view('subcategory.index', compact('subs','cats'));
    }

    public function create(){
        return view('subcategory.create');
    }

    public function store(Request $request){
        $data = $request->all();
        //dd($data);
        if($request->categoria_id == ""){
            alert()->error('Selecione a categoria!');
            
            return redirect()->route('subcategory.index');
        }
        if($request->nome_subcat == ""){
            alert()->error('Prencha a subcategoria!');
            
            return redirect()->route('subcategory.index');
        }
        if($this->model->create($data)){
            alert()->success('Subcategoria cadastrada com sucesso!');

            return redirect()->route('subcategory.index');
        }   
    }

    public function edit($id){
        if(!$cats = $this->model->find($id)){
            return redirect()->route('subcategory.index');
        }
        return view('subcategory.edit', compact('cats'));
    }

    public function update(Request $request, $id){
        //dd($request);
        //dd($data);
        $data = $request->all();
        if(!$cats = $this->model->find($id))
            return redirect()->route('subcategory.index');

        if($cats->update($data)){
            alert()->success('Subcategoria editada com sucesso!');
            return redirect()->route('subcategory.index');
        }
    }

    public function destroy($id){
        if(!$doc = $this->model->find($id)){
            alert()->error('Erro ao excluír a subcategoria!');
        }
        
        if($doc->delete()){
            alert()->success('Subcategoria excluída com sucesso!');
        }

        return redirect()->route('subcategory.index');
    }

    public function obterSubcategorias(Request $request)
    {
        $categoria = $request->input('nome_cat');
        $subcategorias = SubCatDoc::where('nome_cat', $categoria)->get();

        return response()->json($subcategorias);
    }



}
