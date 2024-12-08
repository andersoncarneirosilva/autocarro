<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{
    protected $model;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir essa categoria?";
        confirmDelete($title, $text);

        $clientes = Cliente::paginate(10);
        //dd($docs);
        return view('clientes.index', compact('clientes'));
    }

    
    
    // public function create(){
    //     return view('category.create');
    // }

     public function store(Request $request){
         $data = $request->all();
         //dd($data);
         if($this->model->create($data)){
             alert()->success('Cliente cadastrado com sucesso!');

             return redirect()->route('clientes.index');
         }   
     }
     public function buscarClientes(Request $request)
     {
         $search = $request->get('term');
         $clientes = Cliente::where('nome', 'like', "%$search%")->get();
     
         return response()->json($clientes->map(function ($cliente) {
             return ['id' => $cliente->id, 'text' => $cliente->nome];
         }));
     }
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
