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
        $text = "Deseja excluir esse cliente?";
        confirmDelete($title, $text);

        //$clientes = Cliente::paginate(10);
        $clientes = $this->model->getClientes(search: $request->search ?? '');
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

    public function show($id){
        $configuracao = Cliente::find($id);
        
        if (!$configuracao) {
            return response()->json(['error' => 'Configuração não encontrada'], 404);
        }
    
        return response()->json($configuracao);
    }

     public function update(Request $request, $id){
         //dd($request);
         //dd($data);
         $data = $request->all();
         if(!$cats = $this->model->find($id))
             return redirect()->route('clientes.index');

         if($cats->update($data)){
             alert()->success('Cliente editado com sucesso!');
             return redirect()->route('clientes.index');
         }
     }

     public function destroy($id){
         if(!$doc = $this->model->find($id)){
             alert()->error('Erro ao excluír o cliente!');
         }
        
         if($doc->delete()){
             alert()->success('Cliente excluído com sucesso!');
         }
         return redirect()->route('clientes.index');
     }
}
