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
        $text = "Deseja excluir essa ordem?";
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
        $servicos = Servico::all();
        //dd($clientes);
        return view('ordensdeservicos.create', compact(['clientes','servicos']));

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
        // Obtendo dados específicos do request
        $data = $request->only(['cliente_id', 'tipo_servico', 'servico', 'valor_servico', 'classe_status', 'status']);

        // Garantir que 'cliente_id' seja um valor único
        if (is_array($data['cliente_id'])) {
            $data['cliente_id'] = $data['cliente_id'][0]; // Pegando o primeiro valor do array
        }

        // Se 'tipo_servico' for um array, vamos transformar em uma string
        if (is_array($data['tipo_servico'])) {
            $data['tipo_servico'] = implode(',', $data['tipo_servico']); // Transforma o array em uma string separada por vírgulas
        }

        // Caso precise calcular o valor_total, aqui está o exemplo:
        $data['valor_total'] = str_replace(['R$', ' ', ','], ['', '', '.'], $data['valor_servico']); // Converte o valor de 'valor_servico' para número

        // Tente criar o registro
        if ($this->model->create($data)) {
            alert()->success('Ordem cadastrada com sucesso!');
            return redirect()->route('ordensdeservicos.index');
        }

        alert()->error('Erro ao cadastrar a ordem!');
        return redirect()->route('ordensdeservicos.index');
    }

    public function destroy($id){

        if(!$data = $this->model->find($id)){
            alert()->error('Erro ao excluir a ordem!');
            return redirect()->route('ordensdeservicos.index');
        }

        if($data->delete()){
            alert()->success('Ordem excluída com sucesso!');
        }
        return redirect()->route('ordensdeservicos.index');
    }


}
