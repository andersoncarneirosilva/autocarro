<?php

namespace App\Http\Controllers\Api;

// O segredo está nesta linha abaixo: apontar para a pasta correta do Controller base
use App\Http\Controllers\Controller; 
use App\Models\Veiculo;
use App\Http\Resources\VeiculoResource;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        try {
            // O Trait MultiTenant filtrará automaticamente por empresa_id
            $veiculos = Veiculo::all();
            return VeiculoResource::collection($veiculos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar veículos',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $veiculo = Veiculo::find($id);
            if (!$veiculo) {
                return response()->json(['message' => 'Veículo não encontrado'], 404);
            }
            return new VeiculoResource($veiculo);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePrecos(Request $request, $id)
{
    // Busca o veículo (usando withoutGlobalScopes se necessário, como no seu Dashboard)
    $veiculo = Veiculo::withoutGlobalScopes()->find($id);

    if (!$veiculo) {
        return response()->json(['message' => 'Veículo não encontrado'], 404);
    }

    $validated = $request->validate([
        'valor'               => 'required|numeric',
        'valor_compra'        => 'nullable|numeric',
        'valor_oferta'        => 'nullable|numeric',
        'exibir_parcelamento' => 'required',
        'qtd_parcelas'        => 'required|integer',
        'taxa_juros'          => 'required|numeric',
        'valor_parcela'       => 'nullable|numeric',
    ]);

    try {
        // Atualiza os dados no banco
        $veiculo->update([
            'valor'               => $request->valor,
            'valor_compra'        => $request->valor_compra,
            'valor_oferta'        => $request->valor_oferta,
            'exibir_parcelamento' => $request->exibir_parcelamento,
            'qtd_parcelas'        => $request->qtd_parcelas,
            'taxa_juros'          => $request->taxa_juros,
            'valor_parcela'       => $request->valor_parcela, 
        ]);

        return response()->json(['message' => 'Preços atualizados com sucesso!'], 200);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro ao salvar: ' . $e->getMessage()], 500);
    }
}

public function updateRegistro(Request $request, $id)
{
    $veiculo = Veiculo::findOrFail($id);

    // Validação básica
    $dados = $request->validate([
        'crv'    => 'nullable|string|max:50',
        'renavam'=> 'nullable|string',
        'chassi' => 'nullable|string',
        // Adicione outros campos de registro se quiser que a mesma rota sirva para todos
    ]);

    $veiculo->update($dados);

    return response()->json([
        'message' => 'Dados de registro atualizados com sucesso!',
        'veiculo' => new VeiculoResource($veiculo)
    ]);
}

public function updateInfoBasica(Request $request, $id)
{
    $veiculo = Veiculo::findOrFail($id);

    $request->validate([
        'kilometragem' => 'required|numeric|min:0',
        'cambio'       => 'required',
    ]);

    $data = [
        'cambio'        => $request->cambio,
        'kilometragem'  => $request->kilometragem,
        'portas'        => $request->portas,
        'especiais'     => $request->especiais,
        'marca'         => $request->marca_nome ?: $veiculo->marca,
        'modelo'        => $request->modelo_nome ?: $veiculo->modelo,
        'versao'        => $request->versao_nome ?: $veiculo->versao,
        'fipe_marca_id'  => $request->marca,
        'fipe_modelo_id' => $request->modelo,
        'fipe_versao_id' => $request->versao,
    ];

    if (strtoupper($veiculo->tipo) == 'MOTOCICLETA') {
        $data['portas'] = 0;
    }

    $veiculo->update($data);

    // AJUSTE: Se a requisição vier do App (JSON), retorne JSON. Se vier da Web, redirecione.
    if ($request->wantsJson() || $request->header('Accept') == 'application/json') {
        return response()->json([
            'status' => 'success',
            'message' => 'Informações atualizadas!',
            'data' => $veiculo
        ]);
    }

    return redirect()->back()->with('success', 'Informações atualizadas com sucesso!');
}

public function cadastroRapido(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    // LÓGICA ALCECAR: Identifica o ID da empresa (Dono)
    $empresaId = $user->empresa_id ?? $userId;


    // 1. Validação do Arquivo
    $request->validate([
        'arquivo' => 'required|mimes:pdf|max:10240', 
    ]);

    $arquivo = $request->file('arquivo');
    $size_doc = $arquivo->getSize();

    // 2. Leitura do PDF
    try {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($arquivo->getPathname());
        $textoPagina = $pdf->getPages()[0]->getText();
        //dd($textoPagina);
        $linhas = explode("\n", $textoPagina);

        if (!isset($linhas[3]) || trim($linhas[3]) != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {
            return redirect()->route('veiculos.index')
                ->with('error_title', 'Documento Inválido')
                ->with('error', 'O sistema Alcecar aceita apenas CRLV Digital (PDF) oficial emitido a partir de 2024.');
        }
    } catch (\Exception $e) {
        return redirect()->route('veiculos.index')
            ->with('error_title', 'Erro na leitura')
            ->with('error', 'Não foi possível ler os dados do PDF.');
    }

    // 3. Extração de Dados
    $placa = strtoupper($this->model->extrairPlaca($textoPagina));
    
    // VERIFICAÇÃO MULTI-TENANT: Verifica se a placa já existe NA EMPRESA
    if (Veiculo::where('placa', $placa)->where('empresa_id', $empresaId)->exists()) {
        return redirect()->route('veiculos.index')
            ->with('error_title', 'Veículo já cadastrado')
            ->with('error', "A placa $placa já consta na base de dados da sua empresa.");
    }


    $marca = $this->model->extrairMarca($textoPagina);
    $chassi = $this->model->extrairChassi($textoPagina);
    $cor = $this->model->extrairCor($textoPagina);
    $anoExtraido = $this->model->extrairAnoModelo($textoPagina);
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
    $tipo = $this->model->extrairEspecie($textoPagina);
    $potencia = $this->model->extrairPotencia($textoPagina);
    $peso_bruto = $this->model->extrairPesoBruto($textoPagina);
    $cilindrada = $this->model->extrairCilindrada($textoPagina);
    $carroceria = $this->model->extrairCarroceria($textoPagina);
    $exercicio = $this->model->extrairExercicio($textoPagina);

    //dd($exercicio);
//dd($peso_bruto);
    // Lógica de Marca/Modelo
    $textoLimpo = str_starts_with($marca, 'I/') ? substr($marca, 2) : $marca;
    if (str_contains($textoLimpo, '/')) {
        [$marcaReal, $modeloReal] = explode('/', $textoLimpo, 2);
    } else {
        $partes = explode(' ', $textoLimpo, 2);
        $marcaReal = $partes[0] ?? '';
        $modeloReal = $partes[1] ?? '';
    }

    $partesAno = explode('/', $anoExtraido);
    $anoFabricacao = isset($partesAno[0]) ? (int) preg_replace('/\D/', '', $partesAno[0]) : null;
    $anoModelo     = isset($partesAno[1]) ? (int) preg_replace('/\D/', '', $partesAno[1]) : $anoFabricacao;

    $marcaReal = trim(strtoupper($marcaReal));
    if ($marcaReal === 'VW') $marcaReal = 'VOLKSWAGEN';
    if ($marcaReal === 'GM') $marcaReal = 'CHEVROLET';

    // 4. Criação do Registro no Banco
    $data = [
        'nome' => strtoupper($this->forcarAcentosMaiusculos($nome)),
        'cpf' => $cpf,
        'cidade' => $cidade,
        'marca' => $marcaReal,
        'modelo' => trim(strtoupper($modeloReal)),
        'placa' => $placa,
        'chassi' => strtoupper($chassi),
        'cor' => strtoupper($cor),
        'ano_fabricacao' => $anoFabricacao,
        'ano_modelo'     => $anoModelo,
        'renavam' => $renavam,
        'crv' => $crv,
        'placaAnterior' => $placaAnterior,
        'categoria' => $categoria,
        'motor' => $motor,
        'combustivel' => $combustivel,
        'tipo' => $tipo,
        'infos' => $infos,
        'potencia' => $potencia,
        'cilindrada' => $cilindrada,
        'peso_bruto' => $peso_bruto,
        'carroceria' => $carroceria,
        'exercicio' => $exercicio,
        'status' => 'Disponível',
        'status_Veiculo' => 'Aguardando',
        'size_doc' => $size_doc,
        'user_id' => $userId,      // Quem fez o upload
        'empresa_id' => $empresaId // A qual empresa pertence
    ];

    $novoVeiculo = $this->model->create($data);

    if ($novoVeiculo) {
        // CORREÇÃO: Pegando o ID do veículo recém-criado
        $veiculoId = $novoVeiculo->id;

        // 1. Definição da nova estrutura: documentos/usuario_X/veiculo_Y/
        // LÓGICA ALCECAR: Centralizando documentos por usuário e veículo
        $pastaRelativa = "documentos/usuario_{$userId}/veiculo_{$veiculoId}/"; 
        $pastaDestino = storage_path('app/public/' . $pastaRelativa);

        // 2. Criação da pasta com permissões corretas
        if (!file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        // 3. Nome do arquivo padronizado (Placa limpa sem espaços ou traços)
        $placaLimpa = str_replace(['-', ' '], '', $placa);
        $nomeFinalArquivo = "crlv_{$placaLimpa}.pdf";
        
        // 4. Move o arquivo para a nova pasta
        $arquivo->move($pastaDestino, $nomeFinalArquivo);

        $novoVeiculo->update([
            'arquivo_doc' => $pastaRelativa . $nomeFinalArquivo
        ]);

        if ($request->wantsJson() || $request->header('Accept') == 'application/json') {
            return response()->json([
                'message' => 'Veículo importado com sucesso!',
                'veiculo' => $novoVeiculo
            ], 201);
        }

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo importado e cadastrado com sucesso!');
    }
    
    if ($request->wantsJson()) {
        return response()->json(['error' => 'Erro ao salvar dados'], 500);
    }
    return redirect()->back()->with('error', 'Erro ao salvar os dados do veículo.');
}

}