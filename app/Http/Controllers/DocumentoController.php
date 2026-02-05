<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Cliente;
use App\Models\Outorgado;
use App\Models\Documento;
use App\Models\ModeloProcuracao;
use App\Models\ModeloComunicacao;
use App\Models\ModeloAtpve;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    /**
     * Método Principal para Gerar Documentos (Procuração ou ATPVe)
     */
    public function gerarProcuracao(Request $request, $veiculo_id)
{
    $userId = Auth::id();
    
    // CRIAMOS ESSA VARIÁVEL PARA CURAR O ERRO "UNDEFINED" NAS LINHAS ABAIXO
    $veiculoId = $veiculo_id; 

    $veiculo = Veiculo::findOrFail($veiculoId);
    
    // 1. Validação do Cliente
    if (!$request->cliente_id) {
        return redirect()->back()->with('error', 'Selecione um cliente para gerar o documento.');
    }
    $cliente = Cliente::findOrFail($request->cliente_id);

    // 2. Busca o Modelo
    $modelo = ModeloProcuracao::where('user_id', $userId)->first();

    if (!$modelo) {
        return redirect()->back()->with('error', 'Modelo de procuração não encontrado. Cadastre um modelo.');
    }

    $tipoDoc = $request->input('tipo_documento');

    // Se for ATPV-e, desvia para a lógica específica
    if ($tipoDoc === 'atpve') {
        // Agora $veiculoId existe aqui!
        $this->gerarPdfAtpve($request, $veiculoId);
        
        return redirect()->route('veiculos.show', $veiculoId)
                ->with('success', 'Solicitação ATPV-e gerada com sucesso!');
    }

    if ($tipoDoc === 'comunicação') {
        // Agora $veiculoId existe aqui!
        $this->gerarPdfComunicacao($request, $veiculoId);
        
        return redirect()->route('veiculos.show', $veiculoId)
                ->with('success', 'Comunicação de venda gerada com sucesso!');
    }

    // --- LÓGICA DA PROCURAÇÃO ---
    // Removi o second firstOrFail para não dar erro 404 atoa
    $html = $modelo->conteudo;

    // Substituições de Tags
    $substituicoes = [
        '{NOME_CLIENTE}'     => strtoupper($cliente->nome),
        '{CPF_CLIENTE}'      => $cliente->cpf,
        '{ENDERECO_CLIENTE}' => strtoupper($cliente->endereco . ', ' . $cliente->cidade),
        '{PLACA}'            => strtoupper($veiculo->placa),
        '{CHASSI}'           => strtoupper($veiculo->chassi),
        '{ANO_MODELO}'           => strtoupper($veiculo->ano_fabricacao . '/' . $veiculo->ano_modelo),
        '{RENAVAM}'          => $veiculo->renavam,
        '{MARCA_MODELO}'     => strtoupper($veiculo->marca . ' / ' . $veiculo->modelo),
        '{COR}'              => strtoupper($veiculo->cor),
        '{CIDADE}'           => strtoupper($modelo->cidade),
        '{DATA_EXTENSO}'     => \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y'),
    ];
    $html = str_replace(array_keys($substituicoes), array_values($substituicoes), $html);

    // Lógica do Repetidor de Outorgados
    $outorgadosIds = is_array($modelo->outorgados) ? $modelo->outorgados : json_decode($modelo->outorgados, true);
    $outorgados = \App\Models\Outorgado::whereIn('id', $outorgadosIds ?? [])->get();

    preg_match('/{INICIO_OUTORGADOS}(.*?){FIM_OUTORGADOS}/s', $html, $matches);
    if (isset($matches[1])) {
        $blocoTemplate = $matches[1];
        $blocoProcessado = "";
        foreach ($outorgados as $out) {
            $item = str_replace('{NOME_OUTORGADO}', strtoupper($out->nome_outorgado), $blocoTemplate);
            $item = str_replace('{CPF_OUTORGADO}', $out->cpf_outorgado, $item);
            $item = str_replace('{ENDERECO_OUTORGADO}', strtoupper($out->end_outorgado), $item);
            $blocoProcessado .= $item;
        }
        $html = preg_replace('/{INICIO_OUTORGADOS}.*?{FIM_OUTORGADOS}/s', $blocoProcessado, $html);
    }

    // Caminhos e Salvamento (Mantendo seu padrão documentos/usuario_ID/...)
    $placaLimpa = str_replace([' ', '-'], '', strtoupper($veiculo->placa));
    $nomeArquivo = "procuracao_{$placaLimpa}.pdf";
    $pastaRelativa = "documentos/usuario_{$userId}/veiculo_{$veiculo->id}/";
    $diretorioCompleto = storage_path('app/public/' . $pastaRelativa);

    if (!file_exists($diretorioCompleto)) {
        mkdir($diretorioCompleto, 0755, true);
    }

    $caminhoFisico = $diretorioCompleto . $nomeArquivo;
    $pdf = \Pdf::loadView('pdfs.procuracao', ['corpo' => $html]);
    $pdf->save($caminhoFisico);

    $sizeBytes = filesize($caminhoFisico);

    // Agora $veiculoId existe aqui também!
    Documento::updateOrCreate(
        ['user_id' => $userId, 'veiculo_id' => $veiculoId],
        [
            'cliente_id'    => $cliente->id,
            'arquivo_proc'  => $pastaRelativa . $nomeArquivo,
            'size_proc'     => $sizeBytes,
            'size_proc_pdf' => $this->formatSizeUnits($sizeBytes),
        ]
    );

    return redirect()->route('veiculos.show', $veiculoId)
            ->with('success', 'Procuração emitida e salva com sucesso!');
}

    /**
     * Lógica Específica para ATPV-e
     */
    private function gerarPdfAtpve(Request $request, $veiculoId)
{
    $userId = Auth::id();
    $veiculo = Veiculo::findOrFail($veiculoId);
    $cliente = Cliente::findOrFail($request->cliente_id); 
    
    // 1. SEGURANÇA: Troca firstOrFail por first para tratar o erro amigavelmente
    $modelo = ModeloAtpve::where('user_id', $userId)->first();
    
    if (!$modelo) {
        return redirect()->back()->with('error', 'Modelo de ATPV-e não encontrado. Cadastre um modelo.');
    }
    
    $vendedor = Outorgado::where('user_id', $userId)->first();
    $hoje = \Carbon\Carbon::now();
    $html = $modelo->conteudo;

    $substituicoes = [
        '{NOME_OUTORGADO}'   => $vendedor ? strtoupper($vendedor->nome_outorgado) : 'NÃO INFORMADO',
        '{CPF_OUTORGADO}'    => $vendedor ? $vendedor->cpf_outorgado : '',
        '{EMAIL_OUTORGADO}'  => $vendedor ? $vendedor->email_outorgado : '',
        '{PLACA}'            => strtoupper($veiculo->placa),
        '{CHASSI}'           => strtoupper($veiculo->chassi),
        '{RENAVAM}'          => $veiculo->renavam,
        '{MARCA_MODELO}'     => strtoupper($veiculo->marca . ' / ' . $veiculo->modelo),
        '{COR}'              => strtoupper($veiculo->cor),
        '{VALOR_VENDA}'      => 'R$ ' . ($request->valor_venda ?? '0,00'),
        '{NOME_CLIENTE}'        => strtoupper($cliente->nome),
        '{CPF_CLIENTE}'         => $cliente->cpf,
        '{EMAIL_CLIENTE}'       => $cliente->email ?? 'NÃO INFORMADO',
        '{CEP_CLIENTE}'         => $cliente->cep,
        '{ENDERECO_CLIENTE}'    => strtoupper($cliente->endereco),
        '{NUMERO_CLIENTE}'      => $cliente->numero,
        '{BAIRRO_CLIENTE}'      => strtoupper($cliente->bairro),
        '{CIDADE_CLIENTE}'      => strtoupper($cliente->cidade),
        '{ESTADO_CLIENTE}'      => strtoupper($cliente->estado),
        '{COMPLEMENTO_CLIENTE}' => strtoupper($cliente->complemento ?? ''),
        '{CIDADE}'           => strtoupper($modelo->cidade ?? 'Brasília'),
        '{DATA_EXTENSO}'     => $hoje->translatedFormat('d \d\e F \d\e Y'),
        '{DIA_ATUAL}'    => $hoje->format('d'), 
        '{MES_ATUAL}'    => $hoje->format('m'),
        '{ANO_ATUAL}'    => $hoje->format('Y'),
    ];

    $html = str_replace(array_keys($substituicoes), array_values($substituicoes), $html);

    // 2. CAMINHOS: Padronizando conforme sua estrutura documentos/ID_VEICULO/
    $placaLimpa = str_replace([' ', '-'], '', strtoupper($veiculo->placa));
    $nomeArquivo = "atpve_{$placaLimpa}.pdf";
//    $pastaRelativa = "documentos/{$veiculo->id}/";
    $pastaRelativa = "documentos/usuario_{$userId}/veiculo_{$veiculo->id}/";
    $diretorioCompleto = storage_path('app/public/' . $pastaRelativa);

    if (!file_exists($diretorioCompleto)) {
        mkdir($diretorioCompleto, 0755, true);
    }

    $caminhoFisico = $diretorioCompleto . $nomeArquivo;
    
    // Certifique-se de que a view 'pdfs.solicitacao' existe!
    $pdf = \Pdf::loadView('pdfs.solicitacao', ['corpo' => $html]);
    $pdf->save($caminhoFisico);

    $sizeBytes = filesize($caminhoFisico);

    Documento::updateOrCreate(
        ['user_id' => $userId, 'veiculo_id' => $veiculoId],
        [
            'cliente_id'     => $cliente->id,
            'arquivo_atpve'  => $pastaRelativa . $nomeArquivo,
            'size_atpve'     => $sizeBytes,
            'size_atpve_pdf' => $this->formatSizeUnits($sizeBytes),
        ]
    );

    return true; 
}


private function gerarPdfComunicacao(Request $request, $veiculoId)
{
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;
    
    $veiculo = Veiculo::findOrFail($veiculoId);
    $cliente = Cliente::findOrFail($request->cliente_id); 
    
    $modelo = ModeloComunicacao::where('empresa_id', $empresaId)->first();
    
    if (!$modelo) {
        return redirect()->back()->with('error', 'Modelo de Comunicação não encontrado.');
    }
    
    // 1. Pega o primeiro outorgado vinculado ao modelo
    $outorgadosIds = $modelo->outorgados ?? [];
    $vendedor = Outorgado::whereIn('id', (array)$outorgadosIds)->first();
    
    $hoje = \Carbon\Carbon::now();
    $html = $modelo->conteudo;

    // 2. Remove as tags de repetidor (caso existam no texto) para não sujarem o PDF
    $html = str_replace(['{INICIO_OUTORGADOS}', '{FIM_OUTORGADOS}'], '', $html);

    // 3. Monta o array de substituição único
    $substituicoes = [
        // Dados do Vendedor (Outorgado)
        '{NOME_OUTORGADO}'   => $vendedor ? strtoupper($vendedor->nome_outorgado) : '__________',
        '{CPF_OUTORGADO}'    => $vendedor ? $vendedor->cpf_outorgado : '__________',
        '{RG_OUTORGADO}'     => $vendedor ? $vendedor->rg_outorgado : '__________',
        '{EMAIL_OUTORGADO}'  => $vendedor ? $vendedor->email_outorgado : '__________',
        '{TELEFONE_OUTORGADO}' => $vendedor ? ($vendedor->telefone_outorgado ?? $vendedor->celular_outorgado ?? '__________') : '__________',

        // Dados do Veículo
        '{PLACA}'            => strtoupper($veiculo->placa),
        '{CHASSI}'           => strtoupper($veiculo->chassi),
        '{RENAVAM}'          => $veiculo->renavam,
        '{CRV}'              => $veiculo->crv ?? $veiculo->numero_crv ?? '__________',
        '{MARCA_MODELO}'     => strtoupper($veiculo->marca . ' / ' . $veiculo->modelo),
        '{COR}'              => strtoupper($veiculo->cor),
        '{ANO}'              => $veiculo->ano_fabricacao . '/' . $veiculo->ano_modelo,
        
        // Dados do Comprador (Cliente)
        '{NOME_CLIENTE}'     => strtoupper($cliente->nome),
        '{CPF_CLIENTE}'      => $cliente->cpf,
        '{RG_CLIENTE}'       => $cliente->rg ?? '__________',
        '{EMAIL_CLIENTE}'    => $cliente->email ?? 'NÃO INFORMADO',
        '{TELEFONE_CLIENTE}' => $cliente->telefone ?? $cliente->celular ?? $cliente->fone ?? '__________',
        '{CEP_CLIENTE}'      => $cliente->cep,
        '{ENDERECO_CLIENTE}' => strtoupper($cliente->endereco),
        '{NUMERO_CLIENTE}'   => $cliente->numero,
        '{BAIRRO_CLIENTE}'   => strtoupper($cliente->bairro),
        '{CIDADE_CLIENTE}'   => strtoupper($cliente->cidade),
        '{ESTADO_CLIENTE}'   => strtoupper($cliente->estado),
        
        // Datas e Localização
        '{CIDADE}'           => strtoupper($modelo->cidade ?? '__________'),
        '{DATA_EXTENSO}'     => $hoje->translatedFormat('d \d\e F \d\e Y'),
        '{DIA_ATUAL}'        => $hoje->format('d'), 
        '{MES_ATUAL}'        => $hoje->translatedFormat('F'), 
        '{ANO_ATUAL}'        => $hoje->format('Y'),
    ];

    // 4. Aplica todas as substituições de uma vez
    $html = str_replace(array_keys($substituicoes), array_values($substituicoes), $html);

    // --- GERAÇÃO E SALVAMENTO ---
    $placaLimpa = str_replace([' ', '-'], '', strtoupper($veiculo->placa));
    $nomeArquivo = "comunicacao_{$placaLimpa}.pdf";
    //$pasta = "documentos/{$veiculo->id}/";
    $pasta = "documentos/usuario_{$user->id}/veiculo_{$veiculo->id}/";
    $diretorioCompleto = storage_path('app/public/' . $pasta);



    if (!file_exists($diretorioCompleto)) {
        mkdir($diretorioCompleto, 0755, true);
    }

    $caminhoFisico = $diretorioCompleto . $nomeArquivo;

    $sizeBytes = filesize($caminhoFisico);
    \Pdf::loadView('pdfs.comunicacao', ['corpo' => $html])->save($diretorioCompleto . $nomeArquivo);

    Documento::updateOrCreate(
    [
        'user_id'    => $user->id,
        'veiculo_id' => $veiculo->id,
    ],
    [
        'cliente_id'          => $cliente->id,
        'arquivo_comunicacao' => $pasta . $nomeArquivo,
        'size_comunicacao'    => filesize($diretorioCompleto . $nomeArquivo),
        'size_comunicacao_pdf' => $this->formatSizeUnits($sizeBytes),
    ]
);


    return true; 
}

    /**
     * Helper para formatar o tamanho do arquivo
     */
    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}