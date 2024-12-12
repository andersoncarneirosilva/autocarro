<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Documento;
use Smalot\PdfParser\Parser;
use Carbon\Carbon;
use FPDF;

class ClientesController extends Controller
{
    protected $model;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    public function index(Request $request){

        $title = 'A ação irá excluir o cliente e o veículo!';
        $text = "Deseja continuar?";
        confirmDelete($title, $text);

        //$clientes = Cliente::paginate(10);
        $clientes = $this->model->getClientes(search: $request->search ?? '');
        //dd($docs);
        return view('clientes.index', compact('clientes'));
    }

    
    
     public function create(){
         return view('clientes.create');
     }

     public function store(Request $request){
        
        

        $arquivo = $request->file('arquivo_doc_veiculo');
        
        $nomeOriginal = $arquivo->getClientOriginalName();

        
        
        $parser = new Parser();

        $pdf = $parser->parseFile($arquivo);
        
        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();

            $validador = $this->model->validaDoc($textoPagina);
            //dd($validador);
            $marca = $this->model->extrairMarca($textoPagina);
            $placa = $this->model->extrairPlaca($textoPagina);
            $chassi = $this->model->extrairChassi($textoPagina);
            $cor = $this->model->extrairCor($textoPagina);
            $anoModelo = $this->model->extrairAnoModelo($textoPagina);
            //dd($anoModelo);
            $renavam = $this->model->extrairRevanam($textoPagina);
            $nome = $this->model->extrairNome($textoPagina);
            $cpf = $this->model->extrairCpf($textoPagina);
            $cidade = $this->model->extrairCidade($textoPagina);
            $crv = $this->model->extrairCrv($textoPagina);
            $placaAnterior = $this->model->extrairPlacaAnterior($textoPagina);
            $categoria = $this->model->extrairCategoria($textoPagina);
            $motor = $this->model->extrairMotor($textoPagina);
            $combustivel = $this->model->extrairCombustivel($textoPagina);
            $infos = $this->model->extrairInfos($textoPagina);
            //dd($placaAnterior);
        }

        if($validador == "DEPARTAMENTO NACIONAL DE TRÂNSITO - DENATRAN"){
            alert()->error('Selecione um documento ano 2024!');
            return redirect()->route('documentos.index');
        }else{
            // Garante que a pasta "procuracoes" existe
            $pastaDestino = storage_path('app/public/clientes');
            $urlPDF = asset('storage/clientes/' . $nomeOriginal); 
            if (!file_exists($pastaDestino)) {
                mkdir($pastaDestino, 0777, true); // Cria a pasta
            }

            // Salva o arquivo na pasta
            $caminhoPDF = $pastaDestino . '/' . $nomeOriginal;
            $arquivo->move($pastaDestino, $nomeOriginal);

            // Verifica se o arquivo foi salvo
            if (!file_exists($caminhoPDF)) {
                return response()->json(['error' => 'Erro ao salvar o arquivo.'], 500);
            }

            $data = [
                'marca' => $marca,
                'placa' => $placa,
                'chassi' => $chassi,
                'cor' => $cor,
                'ano' => $anoModelo,
                'renavam' => $renavam,
                'nome' => $nome,
                'cpf' => $cpf,
                'cidade' => $cidade,
                'crv' => $crv,
                'placaAnterior' => $placaAnterior,
                'categoria' => $categoria,
                'motor' => $motor,
                'combustivel' => $combustivel,
                'infos' => $infos,
                'arquivo_doc' => $urlPDF,
            ];


            
        }
        $documento = Documento::create($data);

         if($documento){
            $doc_id = $documento->id;
            
         }  
         //dd($doc_id);

         $dataForm = $request->all();
        $dataForm['doc_id'] = $doc_id;
         $cliente = $this->model->create($dataForm);
 
         if($cliente){
             alert()->success('Cliente e veículo cadastrados com sucesso!');
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
    // public function edit($id){
    //     if(!$cats = $this->model->find($id)){
    //         return redirect()->route('category.index');
    //     }
    //     return view('category.edit', compact('cats'));
    // }

    // public function show($id){
    //     $configuracao = Cliente::find($id);
        
    //     if (!$configuracao) {
    //         return response()->json(['error' => 'Configuração não encontrada'], 404);
    //     }
    
    //     return response()->json($configuracao);
    // }

     public function update(Request $request, $id){
         //dd($request);
         //dd($data);
         $data = $request->all();
         if(!$cats = $this->model->find($id))
             return redirect()->route('clientes.index');

         if($cats->update($data)){
             alert()->success('Cliente editado com sucesso!');
             return redirect()->route('clientes.index');
         }
     }

    public function destroy($id){
        $cli = $this->model->find($id);
        if (!$cli) {
            alert()->error('Erro ao excluir: Cliente não encontrado!');
            return redirect()->route('clientes.index');
        }

        $docs = Cliente::where('id', $id)->first();
        if ($docs) {
            $doc_id = $docs->doc_id;
        } else {
            alert()->error('Documento não encontrado.');
        }

        $documento = Documento::where('id', $docs->doc_id)->first();

        if ($documento) {
            $crlv = $documento->id;  
        } else {
            alert()->error('Documento não encontrado.');
        }

        if ($cli->delete() && ($documento ? $documento->delete() : true)) {
            alert()->success('Cliente e documento excluídos com sucesso!');
        } else {
            alert()->error('Erro ao excluir o cliente ou documento!');
        }

        return redirect()->route('clientes.index');

    }

}
