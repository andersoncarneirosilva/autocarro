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
    // Filtra apenas onde o status é 'ativo' (ou o valor que você usa para itens não arquivados)
    $veiculos = Anuncio::where('status', 'ativo')
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
    //dd($request);
    $data = $request->all();
    //dd($data);
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
    // Carrega o anúncio com os documentos e o cliente já vinculado
    $veiculo = Anuncio::with(['documentos', 'cliente'])->find($id);
    $documentos = Documento::find($id);
    if (!$veiculo) {
        return redirect()->route('anuncios.index');
    }

    $clientes = Cliente::orderBy('nome', 'asc')->get();

    return view('anuncios.show', compact('veiculo', 'clientes','documentos'));
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
        // dd($id);

        if (! $veiculo = $this->model->find($id)) {
            return redirect()->route('anuncios.index')->with('error', 'Veículo não encontrado!');
        }

        if ($veiculo->delete()) {
            return redirect()->route('anuncios.index')->with('success', 'Veículo excluído com sucesso!');
        }
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

public function cadastroRapido(Request $request)
    {

         //dd($request);

        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        // Localiza o usuário logado
        $user = User::find($userId);

        $request->validate([
        'arquivo_doc' => 'required|mimes:pdf|max:10240', // mimes:pdf garante a extensão, max:10240 limita a 10MB
    ], [
        'arquivo_doc.mimes' => 'O documento deve ser obrigatoriamente um arquivo PDF.',
        'arquivo_doc.max' => 'O arquivo não pode ser maior que 10MB.'
    ]);

        $arquivo = $request->file('arquivo_doc');


        // Caminho para a pasta do usuário
        $pastaUsuario = "documentos/usuario_{$userId}/";

        // Tamanho do novo arquivo
        $size_doc = $arquivo->getSize(); // Em bytes
        // dd($tamanhoNovoArquivo);

        $nomeOriginal = $arquivo->getClientOriginalName();

        $parser = new Parser;

        $pdf = $parser->parseFile($arquivo);

        foreach ($pdf->getPages() as $numeroPagina => $pagina) {
            $textoPagina = $pagina->getText();
            //dd($textoPagina);
            $linhas = explode("\n", $textoPagina);
            if ($linhas[3] != 'SECRETARIA NACIONAL DE TRÂNSITO - SENATRAN') {
                alert()->error('Selecione um documento 2024.');

                return redirect()->route('veiculos.index');
            }

            // Extrair dados do veículo
            
            $marca = $this->model->extrairMarca($textoPagina);
            $placa = $this->model->extrairPlaca($textoPagina);
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

            // dd($marca);

            // Verifica se o veículo é importado
            if (strpos($marca, 'I/') === 0) {
                $marcaVeiculo = $this->model->extrairMarcaImportado($textoPagina);
                $modeloVeiculo = $this->model->extrairModeloImportado($textoPagina);
                // dd("Importado: " . $marcaVeiculo) . " Modelo: " . $modeloVeiculo;
            } else {
                $marcaVeiculo = $this->model->extrairMarcaVeiculo($textoPagina);
                $modeloVeiculo = $this->model->extrairModeloVeiculo($textoPagina);
                // dd("Não Importado: " . $marcaVeiculo . " Modelo: " . $modeloVeiculo);
            }

            $nomeImagem = 'images/veiculos/'.strtolower($tipo)."/$modeloVeiculo/".
                strtolower(str_replace(['/', ' '], '_', $marcaVeiculo)).'_'.
                strtolower(str_replace(['/', ' '], '_', $modeloVeiculo)).'_'.
                strtolower(str_replace(' ', '_', $cor)).'.jpg';
             //dd($nomeImagem);
            // Caminho real do arquivo no servidor
            $caminhoImagem = public_path($nomeImagem);

        }

        // Lógica para tratar e separar Marca e Modelo
        $textoLimpo = $marca;

        // 1. Remove o prefixo de importado "I/" se existir
        if (str_starts_with($textoLimpo, 'I/')) {
            $textoLimpo = substr($textoLimpo, 2);
        }

        // 2. Divide a string pelo primeiro "/" encontrado
        if (str_contains($textoLimpo, '/')) {
            [$marcaReal, $modeloReal] = explode('/', $textoLimpo, 2);
        } else {
            $partes = explode(' ', $textoLimpo, 2);
            $marcaReal  = $partes[0] ?? '';
            $modeloReal = $partes[1] ?? '';
        }

        // Limpa espaços em branco e garante maiúsculas
        $marcaReal = trim(strtoupper($marcaReal));
        $modeloReal = trim(strtoupper($modeloReal));

        // --- TRATAMENTO ESPECÍFICO PARA VW ---
        if ($marcaReal === 'VW') {
            $marcaReal = 'VOLKSWAGEN';
        }

        if ($marcaReal === 'GM') {
            $marcaReal = 'CHEVROLET';
        }

        // Verificar se o veículo já existe com a placa fornecida
        $veiculoExistente = Veiculo::where('placa', $placa)
            ->where('user_id', $userId)
            ->first();

        if ($veiculoExistente) {
            alert()->warning('Atenção!', 'Veículo já cadastrado.')
                ->persistent(true)
                ->autoClose(3000) // Fecha automaticamente após 5 segundos
                ->timerProgressBar();

            return redirect()->route('veiculos.index');
        }

        // Garante que a pasta "crlv" existe
        $pastaDestino = storage_path('app/public/'.$pastaUsuario.'crlv/');
        // dd($pastaDestino);
        $numeroRandom = rand(1000, 9999);

        $urlDoc = asset('storage/'.$pastaUsuario.'crlv/'.$placa.'_'.$numeroRandom.'.pdf'); // Adiciona a extensão .pdf
        // dd($urlDoc);

        if (! file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0777, true); // Cria a pasta com permissões recursivas
        }

        // Define o caminho completo do arquivo com a extensão .pdf
        $caminhoDoc = $pastaDestino.$placa.'_'.$numeroRandom.'.pdf';

        // Move o arquivo para a pasta com o nome correto
        $arquivo->move($pastaDestino, $placa.'_'.$numeroRandom.'.pdf');

        // Verifica se o arquivo foi salvo
        if (! file_exists($caminhoDoc)) {
            return response()->json(['error' => 'Erro ao salvar o arquivo.'], 500);
        }

        $nomeFormatado = $this->forcarAcentosMaiusculos($nome);

        // DATA CASDASTRO RAPIDO
        $data = [
            'nome' => strtoupper($nomeFormatado),
            'cpf' => $cpf,
            'cidade' => $cidade,
            'marca' => strtoupper($marca),
            'marca_real' => strtoupper($marcaReal),
            'modelo_real' => strtoupper($modeloReal),
            'placa' => strtoupper($placa),
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
            'status_anuncio' => 'Aguardando publicação',
            'arquivo_doc' => $urlDoc,
            'size_doc' => $size_doc,
            'user_id' => $userId,
        ];

        // CADASTRO RAPIDO
        if ($this->model->create($data)) {

            if ($user && ($user->plano == 'Padrão' || $user->plano == 'Pro' || $user->plano == 'Teste')) {
                $user->decrement('credito', 5);
            }

            return back()->with('success', 'Veículo cadastrado com sucesso!');

            return redirect()->route('veiculos.index');
        }
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