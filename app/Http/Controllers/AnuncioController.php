<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Veiculo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use FPDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AnuncioController extends Controller
{
    protected $model;

    public function __construct(Anuncio $user)
    {
        $this->model = $user;
    }

   public function index()
{
    // Filtra pelos anúncios onde o user_id é o ID do usuário logado
    $veiculos = Anuncio::where('user_id', auth()->id())
                        ->where('status', 'Ativo') 
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

    return view('anuncios.index', compact('veiculos'));
}

    public function indexArquivados()
{
    // Buscamos apenas os que estão com status arquivado
    $veiculos = Anuncio::where('status', 'arquivado')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10);
                        
    return view('anuncios.index', compact('veiculos'));
}

    public function create(){

        return view('anuncios.create');
    }

    public function store(Request $request)
{
    $data = $request->all();
    $paths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = $request->modelo . '_' . Str::random(10) . '.' . $extension;
            $path = $image->storeAs("veiculos/{$request->marca}/fotos", $filename);
            $paths[] = $path;
        }
        $data['images'] = json_encode($paths);
    }

    if ($this->model->create($data)) {
        return redirect()->route('anuncios.index')->with('success', 'Anúncio cadastrado com sucesso!');
    }
}

   public function show($id)
{
    $veiculo = Anuncio::with('user')->findOrFail($id);

    // 1. Tenta buscar a revenda do dono do veículo
    $revenda = \DB::table('revendas')->where('user_id', $veiculo->user_id)->first();

    // 2. Se não achou (como no seu caso do ID 1), busca a revenda do usuário logado
    // Isso garante que você consiga visualizar o anúncio enquanto testa
    if (!$revenda) {
        $revenda = \DB::table('revendas')->where('user_id', auth()->id())->first();
    }

    $slugRevenda = $revenda ? $revenda->slug : 'loja-padrao';

    $documentos = Documento::where('anuncio_id', $id)->first();
    $clientes = Cliente::orderBy('nome', 'asc')->get();

    return view('anuncios.show', compact('veiculo', 'clientes', 'documentos', 'slugRevenda'));
}

    public function update(Request $request, $id)
    {
        $anuncio = Anuncio::findOrFail($id);

        $validated = $request->validate([
            'marca' => 'sometimes|required|string',
            'modelo' => 'sometimes|required|string',
            'ano' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'kilometragem' => 'sometimes|required|integer|min:0',
            'cor' => 'sometimes|required|string',
            'cambio' => 'sometimes|required|string',
            'portas' => 'sometimes|required|integer|min:1|max:5',
            'observacoes' => 'nullable|string',
        ]);

        $anuncio->update($validated);

        return $anuncio;
    }

    public function destroy($id)
{
    $userId = Auth::id();
    
    // 1. Localiza o registro no banco de dados
    if (! $doc = $this->model->find($id)) {
        return redirect()->route('anuncios.index')
            ->with('error_title', 'Erro ao localizar')
            ->with('error', 'Veículo ou documento não encontrado!');
    }

    // 2. Define o caminho da pasta específica deste anúncio
    $caminhoPastaAnuncio = "documentos/usuario_{$userId}/anuncios/anuncio_{$id}/";

    // 3. Exclui a pasta física e todos os arquivos dentro dela (CRLV, procurações, etc.)
    // Usamos o Storage::disk('public')->deleteDirectory para remover a pasta recursivamente
    if (Storage::disk('public')->exists($caminhoPastaAnuncio)) {
        Storage::disk('public')->deleteDirectory($caminhoPastaAnuncio);
    }

    // 4. Exclui o registro do banco de dados
    if ($doc->delete()) {
        return redirect()->route('anuncios.index')
            ->with('success', 'Veículo e todos os arquivos associados foram removidos com sucesso!');
    }

    return redirect()->route('anuncios.index')
        ->with('error', 'Erro ao processar a exclusão no banco de dados.');
}

    public function arquivar($id)
{
    $veiculo = $this->model->find($id); // busca o veículo

    if (!$veiculo) {
        return back()->with('error', 'Erro ao arquivar o veículo!');
    }

    $veiculo->update(['status' => 'Arquivado']);

    return back()->with('success', 'Veículo arquivado com sucesso!');
}

public function desarquivar($id)
{
    $veiculo = $this->model->find($id); // busca o veículo

    if (!$veiculo) {
        return back()->with('error', 'Erro ao restaurar o veículo!');
    }

    $veiculo->update(['status' => 'Ativo']);

    return back()->with('success', 'Veículo restaurado com sucesso!');
}

public function temp(Request $request)
{
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('temp', 'public');
        return response()->json(['path' => $path]);
    }
    return response()->json(['error' => 'Nenhum arquivo enviado.'], 400);
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

    public function cadastroManual()
{
    // Opcional: Você pode carregar marcas pré-definidas ou deixar campos de texto livre
    // como você já tem a lógica de tratamento de marcas, podemos deixar os campos abertos.
    
    return view('anuncios.create-manual');
}

public function storeManual(Request $request)
{
    $data = $request->except(['_token', 'images']);

    // Usuário logado
    $data['user_id'] = Auth::id();

    $adicionaisArray = array_map(function ($item) {
    return ucwords(str_replace('_', ' ', strtolower($item)));
}, $request->input('adicionais', []));

$data['adicionais'] = json_encode($adicionaisArray, JSON_UNESCAPED_UNICODE);


$opcionaisArray = array_map(function ($item) {
    return ucwords(str_replace('_', ' ', strtolower($item)));
}, $request->input('opcionais', []));

$data['opcionais'] = json_encode($opcionaisArray, JSON_UNESCAPED_UNICODE);


    // Upload de imagens
    $imagens = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('veiculos', 'public');
            $imagens[] = $path;
        }
    }

    $data['images'] = json_encode($imagens);

    // Exemplo de campo manual fixo
    $data['status'] = 'ATIVO';

    Anuncio::create($data);

    return redirect()
        ->route('anuncios.index')
        ->with('success', 'Anúncio cadastrado com sucesso!');
}







public function cadastroRapido(Request $request)
{
    $userId = Auth::id();
    $user = Auth::user();

    // 1. Validação do Arquivo
    $request->validate([
        'arquivo_doc' => 'required|mimes:pdf|max:10240',
    ], [
        'arquivo_doc.mimes' => 'O documento deve ser obrigatoriamente um arquivo PDF.',
        'arquivo_doc.max' => 'O arquivo não pode ser maior que 10MB.'
    ]);

    $arquivo = $request->file('arquivo_doc');
    $size_doc = $arquivo->getSize();

    // 2. Leitura do PDF
    try {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($arquivo->getPathname());
        $textoPagina = $pdf->getPages()[0]->getText();
        $linhas = explode("\n", $textoPagina);

        // Validação do órgão emissor e ano (Aviso amigável 2024+)
        if (!isset($linhas[3]) || trim($linhas[3]) != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {
            return redirect()->route('anuncios.index')
                ->with('error_title', 'Documento Inválido')
                ->with('error', 'O sistema Alcecar aceita apenas CRLV Digital (PDF) oficial emitido a partir de 2024.');
        }
    } catch (\Exception $e) {
        return redirect()->route('anuncios.index')
            ->with('error_title', 'Erro na leitura')
            ->with('error', 'Não foi possível ler os dados do PDF. Certifique-se de que não é uma foto convertida em PDF.');
    }

    // 3. Extração de Dados (Usando seu Model)
    $placa = strtoupper($this->model->extrairPlaca($textoPagina));
    
    // Verificar duplicidade antes de processar tudo
    if (Anuncio::where('placa', $placa)->where('user_id', $userId)->exists()) {
        return redirect()->route('anuncios.index')
            ->with('error_title', 'Veículo já cadastrado')
            ->with('error', "A placa $placa já consta em sua base de dados.");
    }

    // Extração dos demais campos
    $marca = $this->model->extrairMarca($textoPagina);
    $chassi = $this->model->extrairChassi($textoPagina);
    $cor = $this->model->extrairCor($textoPagina);
    $anoModelo = $this->model->extrairAnoModelo($textoPagina);
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

    // Lógica de Marca/Modelo
    $textoLimpo = str_starts_with($marca, 'I/') ? substr($marca, 2) : $marca;
    if (str_contains($textoLimpo, '/')) {
        [$marcaReal, $modeloReal] = explode('/', $textoLimpo, 2);
    } else {
        $partes = explode(' ', $textoLimpo, 2);
        $marcaReal = $partes[0] ?? '';
        $modeloReal = $partes[1] ?? '';
    }

    // Normalização de marcas
    $marcaReal = trim(strtoupper($marcaReal));
    if ($marcaReal === 'VW') $marcaReal = 'VOLKSWAGEN';
    if ($marcaReal === 'GM') $marcaReal = 'CHEVROLET';

    // 4. Criação do Registro no Banco (Primeira fase)
    $data = [
        'nome' => strtoupper($this->forcarAcentosMaiusculos($nome)),
        'cpf' => $cpf,
        'cidade' => $cidade,
        'marca' => strtoupper($marca),
        'marca_real' => $marcaReal,
        'modelo_real' => trim(strtoupper($modeloReal)),
        'placa' => $placa,
        'chassi' => strtoupper($chassi),
        'cor' => strtoupper($cor),
        'ano' => $anoModelo,
        'renavam' => $renavam,
        'crv' => $crv,
        'placaAnterior' => $placaAnterior,
        'categoria' => $categoria,
        'motor' => $motor,
        'combustivel' => $combustivel,
        'tipo' => $tipo,
        'infos' => $infos,
        'status' => 'Ativo',
        'status_anuncio' => 'Aguardando',
        'size_doc' => $size_doc,
        'user_id' => $userId,
    ];

    $novoAnuncio = $this->model->create($data);

    if ($novoAnuncio) {
        // 5. Salvamento do Arquivo na nova estrutura: usuario/anuncios/anuncio_{id}
        $anuncioId = $novoAnuncio->id;
        $pastaRelativa = "documentos/usuario_{$userId}/anuncios/anuncio_{$anuncioId}/";
        $pastaDestino = storage_path('app/public/' . $pastaRelativa);

        if (!file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0775, true);
        }

        $nomeFinalArquivo = "crlv_{$placa}.pdf";
        
        // Move o arquivo
        $arquivo->move($pastaDestino, $nomeFinalArquivo);

        // Atualiza o registro com o caminho do arquivo
        $novoAnuncio->update([
            'arquivo_doc' => $pastaRelativa . $nomeFinalArquivo
        ]);

        // 6. Gestão de Créditos
        if ($user && in_array($user->plano, ['Padrão', 'Pro', 'Teste'])) {
            $user->decrement('credito', 5);
        }

        return redirect()->route('anuncios.index')
            ->with('success', 'Veículo importado e cadastrado com sucesso!');
    }

    return redirect()->route('anuncios.index')
        ->with('error', 'Falha ao salvar os dados no sistema.');
}

   public function updateInfoBasica(Request $request, $id)
{
    //dd($request);
    $veiculo = Anuncio::findOrFail($id);
    $tipoVeiculo = strtoupper($veiculo->tipo);

    // Se for motocicleta, injetamos portas 0 antes da validação
    if ($tipoVeiculo === 'MOTOCICLETA') {
        Log::debug("Veículo é uma MOTOCICLETA. Forçando portas para 0.");
        $request->merge(['portas' => 0]);
    }

    $request->validate([
        'estado'     => 'required|string|in:Novo,Semi-novo,Usado',
        'especiais' => 'nullable|string|in:Clássico,Esportivo,Modificado',
        'cambio'             => 'required|string',
        'portas'             => $tipoVeiculo === 'MOTOCICLETA' ? 'nullable' : 'required|integer|min:2|max:5',
        'kilometragem'       => 'required|numeric|min:0',
    ], [
        'estado.required' => 'O estado do veículo é obrigatório.',
        'portas.required'         => 'Informe a quantidade de portas.',
        'kilometragem.min'        => 'A kilometragem não pode ser negativa.'
    ]);

    // O update(all()) funcionará se os campos estiverem no $fillable do Model Anuncio
    $veiculo->update($request->all());

    return redirect()->route('anuncios.show', $id)
                     ->with('success', 'Informações atualizadas com sucesso!');
}

public function updatePrecos(Request $request, $id)
{
    $veiculo = $this->model->findOrFail($id);

    // Limpeza dos dados
    $limparMoeda = function($valor) {
        return (float) str_replace(['.', ','], ['', '.'], $valor);
    };

    $input = $request->all();
    $input['valor'] = $limparMoeda($request->valor);
    $input['valor_oferta'] = $limparMoeda($request->valor_oferta);
    $input['valor_parcela'] = $limparMoeda($request->valor_parcela);
    $input['exibir_parcelamento'] = $request->has('exibir_parcelamento') ? 1 : 0;

    // Validação
    $validator = \Validator::make($input, [
        'valor' => 'required|numeric|min:0.01',
        'valor_oferta' => 'required|numeric|lte:valor',
    ], [
        'valor_oferta.lte' => 'O valor de oferta não pode ser maior que o valor de venda.',
    ]);

    if ($validator->fails()) {
        // O back() com withErrors garante que o modal receba as mensagens
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    if ($veiculo->update($input)) {
        return redirect()->back()->with('success', 'Preços atualizados!');
    }
}

public function updateOpcionais(Request $request, $id)
{
    Log::info("Atualizando opcionais para o ID: {$id}", ['data' => $request->opcionais]);

    try {
        $veiculo = Anuncio::findOrFail($id);

        // Se nenhum checkbox for marcado, o request não envia a chave 'opcionais'
        // Por isso usamos o null coalescing para um array vazio
        $opcionaisArray = $request->input('opcionais', []);

        $veiculo->update([
            'opcionais' => json_encode($opcionaisArray, JSON_UNESCAPED_UNICODE)
        ]);

        return redirect()->route('anuncios.show', $id)->with('success', 'Opcionais atualizados!');

    } catch (\Exception $e) {
        Log::error("Erro ao atualizar opcionais: " . $e->getMessage());
        return back()->with('error', 'Falha ao salvar opcionais.');
    }
}

public function updateModificacoes(Request $request, $id)
{
    try {
        $veiculo = Anuncio::findOrFail($id);
        
        // Captura o array de modificações, se vazio retorna array vazio
        $modificacoes = $request->input('modificacoes', []);

        $veiculo->update([
            'modificacoes' => json_encode($modificacoes, JSON_UNESCAPED_UNICODE)
        ]);

        Log::info("Modificações do veículo {$id} atualizadas por " . auth()->user()->name);

        return redirect()->route('anuncios.show', $id)->with('success', 'Modificações atualizadas com sucesso!');
        
    } catch (\Exception $e) {
        Log::error("Erro ao atualizar modificações do ID {$id}: " . $e->getMessage());
        return back()->with('error', 'Erro ao processar a atualização.');
    }
}

public function updateAdicionais(Request $request, $id)
{
    try {
        $veiculo = Anuncio::findOrFail($id);
        
        // Se nenhum checkbox for marcado, retorna um array vazio
        $adicionais = $request->input('adicionais', []);

        $veiculo->update([
            'adicionais' => json_encode($adicionais, JSON_UNESCAPED_UNICODE)
        ]);

        return redirect()->route('anuncios.show', $id)
                         ->with('success', 'Informações adicionais atualizadas!');
        
    } catch (\Exception $e) {
        Log::error("Erro ao atualizar adicionais do ID {$id}: " . $e->getMessage());
        return back()->with('error', 'Erro ao salvar os dados.');
    }
}

public function updateDescricao(Request $request, $id)
{
    $request->validate([
        'observacoes' => 'nullable|string|max:5000',
    ]);

    try {
        $veiculo = Anuncio::findOrFail($id);
        $veiculo->update([
            'observacoes' => $request->observacoes
        ]);

        return redirect()->back()->with('success', 'Descrição atualizada com sucesso!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao atualizar a descrição.');
    }
}

public function uploadFotos(Request $request, $id)
{
    $request->validate([
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Máximo 2MB por foto
    ]);

    try {
        $veiculo = Anuncio::findOrFail($id);
        
        // Recupera as imagens atuais para não sobrescrever (mantém as antigas e adiciona as novas)
        $imagensAtuais = json_decode($veiculo->images) ?? [];
        $novasImagens = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Salva a imagem na pasta 'public/veiculos' e retorna o caminho
                $path = $image->store('veiculos', 'public');
                $novasImagens[] = $path;
            }
        }

        // Merge das fotos antigas com as novas
        $todasImagens = array_merge($imagensAtuais, $novasImagens);

        $veiculo->update([
            'images' => json_encode($todasImagens)
        ]);

        return back()->with('success', count($novasImagens) . ' fotos adicionadas com sucesso!');

    } catch (\Exception $e) {
        return back()->with('error', 'Erro ao fazer upload das imagens: ' . $e->getMessage());
    }
}

public function deleteFoto($id, $index)
{
    $veiculo = Anuncio::findOrFail($id);
    $imagens = json_decode($veiculo->images, true) ?? [];

    if (isset($imagens[$index])) {
        // Remove arquivo físico
        if (Storage::disk('public')->exists($imagens[$index])) {
            Storage::disk('public')->delete($imagens[$index]);
        }
        
        // Remove do array e reindexa
        unset($imagens[$index]);
        $imagens = array_values($imagens);

        $veiculo->update(['images' => json_encode($imagens)]);

        // Se a requisição for AJAX, retorna JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Foto removida!');
    }

    return response()->json(['success' => false], 404);
}

public function publicar($id)
{
    try {
        $veiculo = Anuncio::findOrFail($id);
        
        // 1. Validação de Fotos
        if (empty($veiculo->images) || $veiculo->images == '[]') {
            return redirect()->back()->with('error', 'Não é possível publicar: O anúncio precisa de pelo menos uma foto.');
        }

        // 2. Validação de Campos Obrigatórios
        // Verificamos se algum dos campos essenciais está vazio
        $camposObrigatorios = [
            'kilometragem' => 'Kilometragem',
            'cambio'       => 'Tipo de câmbio',
            'valor'        => 'Valor do veículo'
        ];

        foreach ($camposObrigatorios as $campo => $nomeFormatado) {
            if (empty($veiculo->$campo)) {
                return redirect()->back()->with('error', "Não é possível publicar: O campo $nomeFormatado é obrigatório.");
            }
        }

        // 3. Atualiza o status para Publicado
        $veiculo->update([
            'status_anuncio' => 'Publicado'
        ]);

        return redirect()->back()->with('success', 'Anúncio publicado com sucesso!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao publicar anúncio: ' . $e->getMessage());
    }
}

public function removerPublicacao($id)
{
    try {
        $veiculo = Anuncio::findOrFail($id);
        
        $veiculo->update([
            'status_anuncio' => 'Aguardando publicação'
        ]);

        return redirect()->back()->with('success', 'Anúncio removido do site.');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao processar solicitação.');
    }
}

}