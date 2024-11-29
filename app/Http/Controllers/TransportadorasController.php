<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportadora;

class TransportadorasController extends Controller
{
    protected $model;

    public function __construct(Transportadora $fornecedor)
    {
        $this->model = $fornecedor;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir essa transportadora?";
        confirmDelete($title, $text);

        $trans = Transportadora::all();
        //dd($trans);
        return view('transportadoras.index', compact(['trans']));
    }

     public function create(){
        $forne = Transportadora::all();
        return view('transportadoras.create', compact('forne'));
    }

    public function store(Request $request){

        $data = $request->all();
        
        /* if($request->colaborador == ""){
            alert()->error('Informe o nome da transportadora!');
            return redirect()->route('transportadoras.index');
        } */

        if($this->model->create($data)){
            alert()->success('Transportadoras cadastrado com sucesso!');

            return redirect()->route('transportadoras.index');
        }
        
    }

    public function edit($id){
        //$forne = $this->model->find($id);
       //dd($forne);
        if(!$forne = $this->model->find($id)){
            return redirect()->route('transportadoras.index');
        }

        return view('transportadoras.edit', compact('forne'));
    }

    public function update(Request $request, $id){
        //dd($request);
        //dd($data);
        $data = $request->all();
        if(!$cats = $this->model->find($id))
            return redirect()->route('transportadoras.index');

        if($cats->update($data)){
            alert()->success('Transportadora editada com sucesso!');
            return redirect()->route('transportadoras.index');
        }
    }

    public function destroy($id){
        if(!$user = $this->model->find($id)){
            return redirect()->route('transportadoras.index');
        }
        
        if($user->delete()){
            alert()->success('Transportadora excluída com sucesso!');
        }
        return redirect()->route('transportadoras.index');
    }
}
