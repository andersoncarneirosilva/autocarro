<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ordem;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Documento;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use FPDF;
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
        $servs = Servico::all();
        dd($ordens);
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
        $veiculos = Documento::all();
        $servicos = Servico::all();
        //dd($clientes);
        return view('ordensdeservicos.create', compact(['clientes','servicos','veiculos']));

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
        $data = $request->only([
            'cliente_id', 
            'documento_id',
            'tipo_servico',
            'descricao',
            'valor_servico',
            'taxa_administrativa',
            'valor_total',
            'forma_pagamento',
            'classe_status',
            'status',
        ]);
        
        // Tratamento dos valores monetários para remover qualquer caractere não visível (como espaços não quebráveis) e símbolos de moeda
        $data['valor_servico'] = str_replace(['R$', '.', ',', "\u{A0}"], ['', '', '.', ''], $request->valor_servico);
        $data['taxa_administrativa'] = str_replace(['R$', '.', ',', "\u{A0}"], ['', '', '.', ''], $request->taxa_administrativa);
        $data['valor_total'] = str_replace(['R$', '.', ',', "\u{A0}"], ['', '', '.', ''], $request->valor_total);
    
        // Garantir que 'cliente_id' seja um valor único
        if (is_array($data['cliente_id'])) {
            $data['cliente_id'] = $data['cliente_id'][0]; // Pegando o primeiro valor do array
        }
    
        // Se 'tipo_servico' for um array, vamos transformar em uma string
        if (is_array($data['tipo_servico'])) {
            $data['tipo_servico'] = implode(',', $data['tipo_servico']); // Transforma o array em uma string separada por vírgulas
        }
    
        // Tente criar o registro
        try {
            $ordemServico = $this->model->create($data);
    
            if ($ordemServico) {
                alert()->success('Ordem cadastrada com sucesso!');
                return redirect()->route('ordensdeservicos.index');
            }
    
            alert()->error('Erro ao cadastrar a ordem!');
            return redirect()->route('ordensdeservicos.index');
        } catch (\Exception $e) {
            // Caso ocorra algum erro, captura e exibe mensagem
            alert()->error('Erro ao cadastrar a ordem: ' . $e->getMessage());
            return redirect()->route('ordensdeservicos.index');
        }
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

    public function gerarPDFOrdemServico(Request $request, $id)
{
    // Obtém os dados da ordem de serviço com o relacionamento do cliente
    $ordemServico = Ordem::with('cliente')->find($id);
    $veiculo = Ordem::with('documento')->find($id);
    //dd($veiculo);
    $servicos = Servico::all();
    // Verifica se a ordem de serviço foi encontrada
    if (!$ordemServico) {
        return redirect()->back()->with('error', 'Ordem de serviço não encontrada');
    }

    // Carregar a data inicial e final, caso precise filtrar ou exibir no relatório
    $dataI = $request->input('dataInicial');
    $dataF = $request->input('dataFinal');
    
    // Aqui você pode aplicar algum filtro se necessário, como:
    // $ordemServico = Ordem::whereBetween('created_at', [$dataI . ' 00:00:00', $dataF . ' 23:59:59'])->get();

    // Carrega a view com os dados da ordem de serviço
    $view = view('relatorios.ordem-de-servico', compact('ordemServico', 'dataI', 'dataF', 'veiculo', 'servicos'))->render();

    // Criação do PDF utilizando o DomPDF
    $pdf = app('dompdf.wrapper');
    $pdf->loadHTML($view)->setPaper('a4', 'portrait'); // Se preferir 'landscape' pode ser ajustado aqui

    // Retorna o PDF para download
    return $pdf->stream('relatorio_ordem_servico.pdf');
}



}
