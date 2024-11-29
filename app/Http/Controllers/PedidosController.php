<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidosController extends Controller
{
    protected $model;

    public function __construct(Pedido $pedi)
    {
        $this->model = $pedi;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse documento?";
        confirmDelete($title, $text);

        $pedidos = Pedido::all();
        //dd($forne);
        return view('pedidos.index', compact(['pedidos']));
    }

     /* public function create(){
        $forne = Fornecedor::all();
        $trans = Transportadora::all();
        //dd($trans);
        return view('fornecedores.create', compact('forne', 'trans'));
    } */

    /* public function store(Request $request){

        $data = $request->all();
        
        if($request->colaborador == ""){
            alert()->error('Selecione o colaborador!');
            return redirect()->route('fornecedores.index');
        }

        if($this->model->create($data)){
            alert()->success('Fornecedor cadastrado com sucesso!');

            return redirect()->route('fornecedores.index');
        }
        
    }

    public function edit($id){
        if(!$forne = $this->model->find($id)){
            return redirect()->route('fornecedores.index');
        }

        return view('fornecedores.edit', compact('forne'));
    } */
/*
    public function destroy($id){
        if(!$user = $this->model->find($id)){
            return redirect()->route('documentos.index');
        }
        
        if($user->delete()){
            alert()->success('Documento excluído com sucesso!');
        }
        return redirect()->route('documentos.index');
    } */
}
