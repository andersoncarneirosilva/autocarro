<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\CatDoc;
use App\Models\Employee;
class DocumentosController extends Controller
{
    protected $model;

    public function __construct(Documento $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request){

        $title = 'Excluir!';
        $text = "Deseja excluir esse documento?";
        confirmDelete($title, $text);

        $categorias = CatDoc::all();
        $docs = $this->model->getDocumentos(colaborador: $request->colaborador, documento: $request->documento ?? '');
        $users = Employee::all();
        //dd($docs);
        
        //dd($users);
        return view('documentos.index', compact(['users', 'docs','categorias']));
    }

    public function create(){
        $users = User::all();
        return view('documentos.create', compact('users'));
    }

    public function store(Request $request){

        $data = $request->all();
        //dd($data);
        $extension = $request->arquivo->getClientOriginalExtension();

        $data['arquivo'] = $request->arquivo->storeAs("documentos/{$request->colaborador}/" . "$request->documento-" . $request->subdocumento . ".{$extension}");
        
        if($request->colaborador == ""){
            alert()->error('Selecione o colaborador!');
            return redirect()->route('documentos.index');
        }

        if($this->model->create($data)){
            alert()->success('Documento cadastrado com sucesso!');

            return redirect()->route('documentos.index');
        }
        
    }

    public function destroy($id){
        if(!$user = $this->model->find($id)){
            return redirect()->route('documentos.index');
        }
        
        if($user->delete()){
            alert()->success('Documento excluído com sucesso!');
        }
        return redirect()->route('documentos.index');
    }
}
