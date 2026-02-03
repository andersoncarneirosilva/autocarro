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

public function importarPdf(Request $request)
{
    $request->validate([
        'arquivo' => 'required|mimes:pdf|max:10240', // Máx 10MB
    ]);

    try {
        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $nomeArquivo = 'crlv_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Salva na pasta storage/app/public/documentos
            $caminho = $file->storeAs('documentos', $nomeArquivo, 'public');

            // Aqui você criaria o veículo. 
            // Dica: Você pode usar bibliotecas como 'smalot/pdfparser' para ler o PDF aqui
            $veiculo = Veiculo::create([
                'status' => 'Disponível',
                'arquivo_doc' => $caminho,
                'modelo' => 'Importado via PDF', // Placeholder até o parser ler o texto
                'user_id' => auth()->id() ?? 1,
                'empresa_id' => auth()->user()->empresa_id ?? 1
            ]);

            return response()->json([
                'message' => 'Arquivo recebido e veículo pré-cadastrado!',
                'veiculo_id' => $veiculo->id,
                'path' => $caminho
            ], 201);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}