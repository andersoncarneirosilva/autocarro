<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use App\Models\Parcela;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmprestimosFormRequest;
class EmprestimosController extends Controller
{   

    protected $model;

    public function __construct(Emprestimo $empres)
    {
        $this->model = $empres;
    }

    public function index(Request $request){
        
        $empres = $this->model->getEmprestimos(search: $request->search ?? '');
        $parcelas = Parcela::get();
        $users = User::all();
        //dd($empres);
        $title = 'Excluir!';
        $text = "Deseja excluir esse emprestimo?";
        confirmDelete($title, $text);
        //dd($empres);
        return view('emprestimos.index', compact('empres','parcelas','users'));
    }

    public function create(){
        $users = User::all();
        return view('emprestimos.create', compact('users'));
    }

    public function store(Request $request){
        $data = $request->all();

        if($request->colaborador == ""){
            alert()->error('Selecione o colaborador!');
            return redirect()->route('emprestimos.index');
        }

        $getLastId = $this->model->create($data);
        $lastInsertedId= $getLastId->id;

        $data = $lastInsertedId;

        $dataVencimento = Carbon::parse($request->data_vencimento);
        //dd($request->data_vencimento);
        for($i = 0; $i < $request->qt_parcela; $i++){
            Parcela::create(['qt_parcela' => $request->qt_parcela,
                            'parcela' => $request->parcela,
                            'total' => $request->total,
                            'class_status' => $request->class_status,
                            'status' => $request->status,
                            'vencimento_at' => $dataVencimento,
                            'emprestimo_id' => $lastInsertedId
            ]);
            $dataVencimento->addMonths(1);
        }

        alert()->success('Emprestimo cadastrado com sucesso!');

        return redirect()->route('emprestimos.index');
        
    }

    public function destroy($id){
        if(!$user = $this->model->find($id)){
            return redirect()->route('emprestimos.index');
        }
        
        if($user->delete()){
            DB::table('parcelas')->where('emprestimo_id', $id)->delete();
            alert()->success('Emprestimo excluído com sucesso!');
        }
        return redirect()->route('emprestimos.index');
    }

    
    
}
