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

    public function index(Request $request)
{
    $title = 'Excluir!';
    $text = "Deseja excluir essa ordem?";
    confirmDelete($title, $text);

    // Carrega as ordens com os clientes relacionados
    $ordens = Ordem::with('cliente')->paginate(10);
    $clientes = Cliente::all();
    $servs = Servico::all();

    // Manipula o campo tipo_servico para garantir que seja um array
    foreach ($ordens as $orden) {
        // Decodifica o campo tipo_servico para um array se for um JSON
        if ($orden->tipo_servico) {
            $orden->tipo_servico = json_decode($orden->tipo_servico, true); // Converte para array
        }
    }

    // Passa os dados para a view
    return view('ordensdeservicos.index', compact(['ordens', 'clientes']));
}


public function show($id)
{
    // Encontre a ordem
    $order = $this->model->find($id);
    if (!$order) {
        return redirect()->route('ordensdeservicos.index');
    }

    // Carregar dados da ordem com os relacionamentos necessários
    $ordens = Ordem::with(['cliente', 'documento'])->find($id); // Melhor carregar cliente e documento ao mesmo tempo

    // Decodificar o tipo_servico em array, se for um JSON
    $tiposServico = json_decode($ordens->tipo_servico, true);

    // Verifique se tipo_servico foi decodificado corretamente
    if (!is_array($tiposServico)) {
        $tiposServico = []; // Se não for um array válido, defina como array vazio
    }

    // Obter os valores para cada tipo de serviço
    $valoresServicos = [];
    foreach ($tiposServico as $tipo) {
        // Obter valor e taxa de cada tipo de serviço
        $valor_servico = $this->getValorServico($tipo);
        $taxa_administrativa = $this->getTaxaAdministrativa($tipo);
        $valor_total = $valor_servico + $taxa_administrativa;

        // Adicionando os valores ao array
        $valoresServicos[] = [
            'tipo' => $tipo,
            'valor_servico' => $valor_servico,
            'taxa_administrativa' => $taxa_administrativa,
            'valor_total' => $valor_total
        ];
    }
    $veiculo = Ordem::with('documento')->find($id);
    $servicos = Servico::all();

    return view('ordensdeservicos.show', compact(['order', 'ordens', 'veiculo', 'servicos','valoresServicos']));
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



    public function store(Request $request)
{
    try {
        // Obtendo dados específicos do request
        $data = $request->only([
            'cliente_id', 
            'documento_id',
            'tipo_servico',
            'descricao',
            'forma_pagamento',
            'classe_status',
            'status',
        ]);
        //$valor_servico = $this->getValorServico($request->tipo_servico);
       

        // Verificar se tipo_servico é um array
        if (is_array($data['tipo_servico'])) {
            // Inicializando os valores totais para acumular
            $valor_servico_total = 0;
            $taxa_administrativa_total = 0;
            $valor_total_total = 0;
            
            // Array para armazenar os valores dos serviços
            $valores_servicos = [];

            // Processar os tipos de serviço e calcular os valores
            foreach ($data['tipo_servico'] as $tipo) {
                // Aqui você chama as funções para obter os valores de cada tipo de serviço
                $valor_servico = $this->getValorServico($tipo);  // Função para obter o valor
                $taxa_administrativa = $this->getTaxaAdministrativa($tipo);  // Função para obter a taxa
                $valor_total = $valor_servico + $taxa_administrativa;
                
                // Armazenar os valores para cada tipo de serviço
                $valores_servicos[] = [
                    'tipo' => $tipo,
                    'valor_servico' => $valor_servico,
                    'taxa_administrativa' => $taxa_administrativa,
                    'valor_total' => $valor_total
                ];

                // Acumulando os totais
                $valor_servico_total += $valor_servico;
                $taxa_administrativa_total += $taxa_administrativa;
                $valor_total_total += $valor_total;
            }

            // Armazenando os valores dos serviços no array $data
            $data['valores_servicos'] = $valores_servicos;
            //dd($data['valores_servicos']);
            
            // Convertendo tipo_servico em JSON (já que pode ser um array)
            $data['tipo_servico'] = json_encode($data['tipo_servico']);



        } else {
            throw new \Exception("O campo 'tipo_servico' precisa ser um array.");
        }

        // Remover formatação de R$ e valores extra
        $data['valor_servico'] = str_replace(['R$', '.', ',', "\u{A0}"], ['', '', '.', ''], $request->valor_servico);
        $data['taxa_administrativa'] = str_replace(['R$', '.', ',', "\u{A0}"], ['', '', '.', ''], $request->taxa_administrativa);
        $data['valor_total'] = str_replace(['R$', '.', ',', "\u{A0}"], ['', '', '.', ''], $request->valor_total);
//
        // Salvando no banco de dados
        //dd($data);
        Ordem::create($data);

        alert()->success('Ordem cadastrada com sucesso!');
        return redirect()->route('ordensdeservicos.index');

    } catch (\Exception $e) {
        alert()->error('Erro ao cadastrar a ordem!')->persistent('Fechar');
        return redirect()->route('ordensdeservicos.index');
    }
}

private function getValorServico($tipo)
{
    //dd($tipo);
    // Função para buscar o valor do serviço, baseado no tipo
    $servico = Servico::where('nome_servico', $tipo)->first();
    $valor_servico = $servico->valor_servico;
    //dd("Valor servico: " . $valor_servico);
    
    if ($servico) {
        return $servico->valor_servico; // Retorna o valor do serviço
    }

    return 0; // Retorna 0 caso o serviço não seja encontrado
}

private function getTaxaAdministrativa($tipo)
{
    //dd("Tipo:" . $tipo);
    // Função para buscar a taxa administrativa, baseado no tipo
    $servico = Servico::where('nome_servico', $tipo)->first(); // Ajuste conforme o nome da coluna 'tipo'
    
    if ($servico) {
        return $servico->taxa_servico; // Retorna a taxa administrativa do serviço
    }

    return 0; // Retorna 0 caso o serviço não seja encontrado
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
