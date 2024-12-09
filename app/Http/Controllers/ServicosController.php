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
         $data = $request->all();
         //dd($data);
         if($this->model->create($data)){
            alert()->success('Serviço cadastrado com sucesso!');

            return redirect()->route('servicos.index');
        }
     }

    // public function edit($id){
    //     if(!$cats = $this->model->find($id)){
    //         return redirect()->route('subcategory.index');
    //     }
    //     return view('subcategory.edit', compact('cats'));
    // }

    // public function update(Request $request, $id){
    //     //dd($request);
    //     //dd($data);
    //     $data = $request->all();
    //     if(!$cats = $this->model->find($id))
    //         return redirect()->route('subcategory.index');

    //     if($cats->update($data)){
    //         alert()->success('Subcategoria editada com sucesso!');
    //         return redirect()->route('subcategory.index');
    //     }
    // }

    public function destroy($id){
        if(!$doc = $this->model->find($id)){
            alert()->error('Erro ao excluír o serviço!');
        }
       
        if($doc->delete()){
            alert()->success('Serviço excluído com sucesso!');
        }
         return redirect()->route('servicos.index');
    }

    // public function obterSubcategorias(Request $request)
    // {
    //     $categoria = $request->input('nome_cat');
    //     $subcategorias = SubCatDoc::where('nome_cat', $categoria)->get();

    //     return response()->json($subcategorias);
    // }



}
