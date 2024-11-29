<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\Transportadora;

class FornecedorController extends Controller
{
    protected $model;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->model = $fornecedor;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse documento?";
        confirmDelete($title, $text);

        $forne = Fornecedor::all();
        //dd($forne);
        return view('fornecedores.index', compact(['forne']));
    }

     public function create(){
        $forne = Fornecedor::all();
        $trans = Transportadora::all();
        //dd($trans);
        return view('fornecedores.create', compact('forne', 'trans'));
    }

    public function store(Request $request){

        $data = $request->all();
        
        /* if($request->colaborador == ""){
            alert()->error('Selecione o colaborador!');
            return redirect()->route('fornecedores.index');
        } */

        if($this->model->create($data)){
            alert()->success('Fornecedor cadastrado com sucesso!');

            return redirect()->route('fornecedores.index');
        }
        
    }

    public function edit($id){
        //$forne = $this->model->find($id);
       //dd($forne);
        if(!$forne = $this->model->find($id)){
            return redirect()->route('fornecedores.index');
        }

        return view('fornecedores.edit', compact('forne'));
    }
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
