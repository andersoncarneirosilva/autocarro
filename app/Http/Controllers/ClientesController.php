<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Documento;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use FPDF;
use App\Rules\ValidCPF;
class ClientesController extends Controller
{
    protected $model;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    public function index(Request $request){

        $title = 'Atenção';
        $text = "Deseja excluir esse cliente?";
        confirmDelete($title, $text);

        // Obtendo o ID do usuário logado
    $userId = Auth::id();

    // Filtrando os clientes do usuário logado e realizando a pesquisa
    $clientes = $this->model->getClientes($request->search, $userId);
        //dd($docs);
        return view('clientes.index', compact('clientes'));
    }



    
    
     public function create(){
         return view('clientes.create');
     }

     public function store(Request $request)
{
    $userId = Auth::id(); // Obtendo o ID do usuário logado
    $data = $request->all(); // Obtendo todos os dados da requisição

    try {
        // Validação dos dados do cliente
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'fone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cep' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        alert()->error('Todos os campos são obrigatórios!');
        return redirect()->route('clientes.create');
    }

    // Adicionando o user_id ao array de dados
    $validatedData['user_id'] = $userId;

    // Criação do cliente no banco de dados
    $cliente = $this->model->create($validatedData);

    if ($cliente) {
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

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'fone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cep' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ], [
            'required' => 'Todos os campos são obrigatórios.', // Mensagem genérica
        ]);
    
        // Busca o cliente pelo ID
        $cliente = $this->model->find($id);
    
        // Verifica se o cliente existe
        if (!$cliente) {
            alert()->error('Erro: Cliente não encontrado!');
            return redirect()->route('clientes.index');
        }
    
        // Atualiza o cliente com os dados validados
        $cliente->update($validatedData);
    
        // Mensagem de sucesso
        alert()->success('Cliente atualizado com sucesso!');
        return redirect()->route('clientes.index');
    }
    

     public function destroy($id)
     {
         // Procura o cliente pelo ID
         $cli = $this->model->find($id);
     
         // Verifica se o cliente existe
         if (!$cli) {
             alert()->error('Erro ao excluir: Cliente não encontrado!');
             return redirect()->route('clientes.index');
         }
     
         // Exclui o cliente
         $cli->delete();
     
         // Retorna com mensagem de sucesso
         alert()->success('Cliente excluído com sucesso!');
         return redirect()->route('clientes.index');
     }
     

}
