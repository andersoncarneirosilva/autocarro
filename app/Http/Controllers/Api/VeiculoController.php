<?php

namespace App\Http\Controllers\Api;

// O segredo está nesta linha abaixo: apontar para a pasta correta do Controller base
use App\Http\Controllers\Controller; 
use App\Models\Veiculo;
use App\Http\Resources\VeiculoResource;
use Illuminate\Http\Request;
use App\Mail\SendEmailAtpve;
use App\Mail\SendEmailProc;
use App\Models\Cliente;
use App\Models\ModeloProcuracao;
use App\Models\Outorgado;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class VeiculoController extends Controller
{
    public function index()
{
    try {
        // Definimos o que é considerado "Estoque"
        $statusEstoque = ['Ativo', 'Disponível', 'disponível'];

        // O Trait MultiTenant continua agindo, mas agora filtramos o status
        $veiculos = Veiculo::whereIn('status', $statusEstoque)
            ->orderBy('created_at', 'desc') // Opcional: mostrar os mais novos primeiro
            ->get();

        return VeiculoResource::collection($veiculos);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erro ao listar veículos em estoque',
            'details' => $e->getMessage()
        ], 500);
    }
}

    public function show($id)
{
    // Carrega o veículo com a relação
    $veiculo = Veiculo::with(['documentos'])->findOrFail($id);
    
    // Retorna o Resource que acabamos de ajustar
    return new VeiculoResource($veiculo);
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



public function updateInfoBasica(Request $request, $id)
{
    $veiculo = Veiculo::findOrFail($id);

    $request->validate([
        'kilometragem' => 'required|numeric|min:0',
        'cambio'       => 'required',
        // Adicione validação para placa se desejar
    ]);

    $data = [
        'cambio'         => $request->cambio,
        'kilometragem'   => $request->kilometragem,
        'placa'          => $request->placa,          // ADICIONE ESTA LINHA
        'cor'            => $request->cor,            // ADICIONE ESTA LINHA
        'ano_fabricacao' => $request->ano_fabricacao, // ADICIONE ESTA LINHA
        'ano_modelo'     => $request->ano_modelo,     // ADICIONE ESTA LINHA
        'portas'         => $request->portas,
        'especiais'      => $request->especiais,
        'marca'          => $request->marca_nome ?: $veiculo->marca,
        'modelo'         => $request->modelo_nome ?: $veiculo->modelo,
        'versao'         => $request->versao_nome ?: $veiculo->versao,
        'fipe_marca_id'  => $request->marca,
        'fipe_modelo_id' => $request->modelo,
        'fipe_versao_id' => $request->versao,
    ];

    if (strtoupper($veiculo->tipo) == 'MOTOCICLETA') {
        $data['portas'] = 0;
    }

    $veiculo->update($data);

    if ($request->wantsJson() || $request->header('Accept') == 'application/json') {
        return response()->json([
            'status' => 'success',
            'message' => 'Informações atualizadas!',
            'data' => $veiculo->refresh() // refresh() garante que o retorno venha do banco atualizado
        ]);
    }

    return redirect()->back()->with('success', 'Informações atualizadas com sucesso!');
}

public function updateRegistro(Request $request, $id)
{
    try {
        $veiculo = Veiculo::findOrFail($id);
        
        // Lista exata dos campos permitidos
        $campos = [
            'renavam', 'chassi', 'motor', 'crv', 'placa_anterior', 
            'categoria', 'combustivel', 'potencia', 'cilindrada', 
            'peso_bruto', 'carroceria', 'infos', 'cpf', 'cidade', 'nome'
        ];

        // Coleta apenas o que foi enviado
        $data = $request->only($campos);

        // Opcional: Limpeza rápida de strings (trim) para evitar espaços em branco acidentais
        $data = array_map(function($value) {
            return is_string($value) ? trim($value) : $value;
        }, $data);
        
        // Executa o update
        $veiculo->update($data);

        // Retorna como Array para satisfazer o VeiculoResponse do Android (BEGIN_ARRAY)
        return response()->json([
            'status' => 'success',
            'message' => 'Dados de registro atualizados com sucesso!',
            'data' => [$veiculo->fresh()] // fresh() garante que mandamos o dado recém-salvo
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Falha ao atualizar: ' . $e.getMessage()
        ], 500);
    }
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
    $veiculoModel = new \App\Models\Veiculo();
    // 2. Leitura do PDF
    try {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($arquivo->getPathname());
        $textoPagina = $pdf->getPages()[0]->getText();
        //dd($textoPagina);
        $linhas = explode("\n", $textoPagina);

        if (!isset($linhas[3]) || trim($linhas[3]) != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {

            if (request()->expectsJson()) {
                return response()->json([
                    'error_title' => 'Documento Inválido',
                    'message' => 'O sistema aceita apenas CRLV emitido a partir de 2023.'
                ], 422);
            }

            return redirect()->route('veiculos.index')
                ->with('error_title', 'Documento Inválido')
                ->with('error', 'O sistema aceita apenas CRLV emitido a partir de 2023.');
        }
    } catch (\Exception $e) {
        return redirect()->route('veiculos.index')
            ->with('error_title', 'Erro na leitura')
            ->with('error', 'Não foi possível ler os dados do PDF.');
    }

    // 3. Extração de Dados
    $placa = strtoupper($veiculoModel->extrairPlaca($textoPagina));
    
    // VERIFICAÇÃO MULTI-TENANT: Verifica se a placa já existe NA EMPRESA
    if (Veiculo::where('placa', $placa)->where('empresa_id', $empresaId)->exists()) {
    // Forçamos a resposta JSON imediatamente para evitar redirecionamentos do middleware
    return response()->json([
        'error' => "A placa $placa já consta na sua base de dados."
    ], 422); 
}


    $marca = $veiculoModel->extrairMarca($textoPagina);
    $chassi = $veiculoModel->extrairChassi($textoPagina);
    $cor = $veiculoModel->extrairCor($textoPagina);
    $anoExtraido = $veiculoModel->extrairAnoModelo($textoPagina);
    $renavam = $veiculoModel->extrairRevanam($textoPagina);
    $nome = $veiculoModel->extrairNome($textoPagina);
    $cpf = $veiculoModel->extrairCpf($textoPagina);
    $cidade = $veiculoModel->extrairCidade($textoPagina);
    $crv = $veiculoModel->extrairCrv($textoPagina);
    $placaAnterior = $veiculoModel->extrairPlacaAnterior($textoPagina);
    $categoria = $veiculoModel->extrairCategoria($textoPagina);
    $motor = $veiculoModel->extrairMotor($textoPagina);
    $combustivel = $veiculoModel->extrairCombustivel($textoPagina);
    $infos = $veiculoModel->extrairInfos($textoPagina);
    $tipo = $veiculoModel->extrairEspecie($textoPagina);
    $potencia = $veiculoModel->extrairPotencia($textoPagina);
    $peso_bruto = $veiculoModel->extrairPesoBruto($textoPagina);
    $cilindrada = $veiculoModel->extrairCilindrada($textoPagina);
    $carroceria = $veiculoModel->extrairCarroceria($textoPagina);
    $exercicio = $veiculoModel->extrairExercicio($textoPagina);

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

    $novoVeiculo = $veiculoModel->create($data);

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

public function forcarAcentosMaiusculos($texto)
    {
        // Mapeia as letras acentuadas minúsculas para suas versões maiúsculas
        $mapaAcentos = [
            'á' => 'Á', 'à' => 'À', 'ã' => 'Ã', 'â' => 'Â', 'é' => 'É',
            'è' => 'È', 'ê' => 'Ê', 'í' => 'Í', 'ó' => 'Ó', 'ò' => 'Ò',
            'õ' => 'Õ', 'ô' => 'Ô', 'ú' => 'Ú', 'ù' => 'Ù', 'ç' => 'Ç',
        ];

        // Substitui as letras minúsculas acentuadas pelas versões maiúsculas
        $texto = strtr($texto, $mapaAcentos);

        // Substituições de caracteres "estranhos" causados por problemas de codificação
        $substituicoesCodificacao = [
            'Ã‘' => 'Ñ',   // Para corrigir "Ã‘" que deveria ser "Ñ"
            'Ã©' => 'é',   // Para corrigir "Ã©" que deveria ser "é"
            'Ã´' => 'ô',   // Para corrigir "Ã´" que deveria ser "ô"
            'Ã•' => 'Á',
            // Adicione outras substituições conforme necessário
        ];

        // Realiza as substituições
        $texto = strtr($texto, $substituicoesCodificacao);

        // Retorna o texto já com as letras acentuadas forçadas para maiúsculas e a correção de codificação
        return $texto;
    }

   public function storeManual(Request $request)
{
    try {
        $validatedData = $request->validate([
            'tipo'           => 'required|string',
            'marca'          => 'required|string',
            'modelo'         => 'required|string',
            'versao'         => 'nullable|string',
            'placa'          => 'required|string|unique:veiculos,placa',
            'ano_fabricacao' => 'required|string',
            'ano_modelo'     => 'required|string',
            'cor'            => 'nullable|string',
            'combustivel'    => 'nullable|string',
            'cambio'         => 'nullable|string',
            'kilometragem'   => 'required|integer',
            'portas'         => 'nullable|string',
            'preco_fipe'     => 'nullable|string',
            'fipe_marca_id'  => 'nullable|string',
            'fipe_modelo_id' => 'nullable|string',
            'fipe_versao_id' => 'nullable|string',
        ]);

        // O Trait cuida do empresa_id no boot, 
        // mas o user_id geralmente precisa ser definido manualmente:
        $validatedData['user_id'] = auth()->id();

        // Criar o registro
        $veiculo = Veiculo::create($validatedData);

        return response()->json([
            'message' => 'Veículo cadastrado com sucesso!',
            'data'    => $veiculo
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erro interno ao salvar veículo',
            'error'   => $e->getMessage()
        ], 500);
    }
}

public function archive($id)
{
    try {
        $veiculo = Veiculo::findOrFail($id);

        // Atualiza o status
        $veiculo->status = 'Arquivado';
        $veiculo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Veículo ' . $veiculo->modelo . ' arquivado com sucesso no Alcecar.'
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Veículo não encontrado para arquivamento.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao arquivar: ' . $e->getMessage()
        ], 500);
    }
}

// 2. EXCLUIR (Remove do banco)
// App\Http\Controllers\Api\VeiculoController.php

public function destroy($id)
{
    try {
        $veiculo = Veiculo::findOrFail($id);

        // Opcional: Se você quiser deletar os documentos físicos antes de apagar do banco
        if ($veiculo->documentos) {
            // Lógica para deletar arquivos do storage se necessário
            $veiculo->documentos()->delete(); 
        }

        $veiculo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Veículo removido com sucesso do sistema Alcecar.'
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Veículo não encontrado.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Erro interno: ' . $e->getMessage()
        ], 500);
    }
}

}