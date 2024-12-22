<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Documento;
use Smalot\PdfParser\Parser;
use Carbon\Carbon;
use FPDF;

class ClientesController extends Controller
{
    protected $model;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    public function index(Request $request){

        $title = 'A ação irá excluir o cliente e o veículo!';
        $text = "Deseja continuar?";
        confirmDelete($title, $text);

        //$clientes = Cliente::paginate(10);
        $clientes = $this->model->getClientes(search: $request->search ?? '');
        //dd($docs);
        return view('clientes.index', compact('clientes'));
    }

    
    
     public function create(){
         return view('clientes.create');
     }

     public function store(Request $request){

        $data = $request->all();

        $cliente = $this->model->create($data);

        if($cliente){
            alert()->success('Cliente cadastrado com sucesso!');
        } 
        return redirect()->route('clientes.index');
    }

     public function buscarClientes(Request $request)
     {
         $search = $request->get('term');
         $clientes = Cliente::where('nome', 'like', "%$search%")->get();
     
         return response()->json($clientes->map(function ($cliente) {
             return ['id' => $cliente->id, 'text' => $cliente->nome];
         }));
     }

    public function edit($id){
        
        if(!$cliente = $this->model->find($id)){
            return redirect()->route('clientes.index');
        }
        //dd($cliente);

        return view('clientes.edit', compact('cliente'));
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

        $cli = $this->model->find($id);
        if (!$cli) {
            alert()->error('Erro ao excluir: Cliente não encontrado!');
            return redirect()->route('clientes.index');
        }

        alert()->success('Cliente excluído com sucesso!');
        return redirect()->route('clientes.index');

    }

}
