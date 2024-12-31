<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ordem;
use App\Models\Cliente;
use App\Models\Servico;
class OrdemController extends Controller
{
    protected $model;

    public function __construct(Ordem $order){

        $this->model = $order;
    }

    public function index(Request $request){
        $title = 'Excluir!';
        $text = "Deseja excluir essa procuração?";
        confirmDelete($title, $text);

        // Carrega as ordens com os clientes relacionados
        $ordens = Ordem::with('cliente')->paginate(10);
        $clientes = Cliente::all();
        //dd($clientes);
        return view('ordensdeservicos.index', compact(['ordens', 'clientes']));
    }

    public function show($id){
        if(!$order = $this->model->find($id)){
            return redirect()->route('ordensdeservicos.index');
        }

        $title = 'Excluir!';
        $text = "Deseja excluir esse usuário?";
        confirmDelete($title, $text);
        
        return view('ordensdeservicos.show', compact('order'));
    }

    public function create(){
        $clientes = Cliente::all();
        //dd($clientes);
        return view('ordensdeservicos.create', compact(['clientes']));

    }

    public function buscarClientes(Request $request)
{
    $query = $request->get('query', '');

    $clientes = Cliente::where('nome', 'like', '%' . $query . '%')
        ->select('id', 'nome', 'email', 'cpf', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado')
        ->get();

    return response()->json($clientes);
}

    public function buscarServicos(Request $request)
    {
        $query = $request->get('query', '');

        $servicos = Servico::where('nome_servico', 'like', '%' . $query . '%')
            ->select('id', 'nome_servico', 'valor_servico', 'arrecadacao_servico', 'maodeobra_servico')
            ->get();

        return response()->json($servicos);
    }



    public function store(Request $request){
        //dd($request->nome_cliente);
    }

}
