<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Parsedown;
use Illuminate\Support\Facades\DB;
class LojaController extends Controller
{
    protected $model;

    public function __construct(Anuncio $veiculos)
    {
        $this->model = $veiculos;
    }

    public function index(Request $request)
{
    //dd($request);
    // Inicia a query filtrando apenas anúncios publicados
    $query = Anuncio::with(['user.revenda', 'user.particular'])->where('status_anuncio', 'Publicado');

    // Executa a paginação após aplicar o filtro
    $veiculos = $query->paginate(10);

    $dadosAgrupados = Anuncio::where('status', 'Ativo')
        ->select('marca_real', 'modelo_real')
        ->get()
        ->groupBy('marca_real')
        ->map(function ($itens) {
            return $itens->pluck('modelo_real')->unique()->values();
        });

    // Ajusta marca e modelo apenas para exibição
    $veiculos->getCollection()->transform(function ($veiculo) {
        // --- LÓGICA DE MARCA/MODELO (mantida) ---
        $texto = $veiculo->marca;
        if (str_starts_with($texto, 'I/')) $texto = substr($texto, 2);
        
        if (str_contains($texto, '/')) {
            [$marca, $modelo] = explode('/', $texto, 2);
        } else {
            $partes = explode(' ', $texto, 2);
            $marca = $partes[0] ?? '';
            $modelo = $partes[1] ?? '';
        }
        $veiculo->marca_exibicao = trim($marca);
        $veiculo->modelo_exibicao = trim($modelo);

        // --- NOVA LÓGICA: DEFINIR O SLUG DA LOJA ---
        // Se o usuário tem uma revenda, pega o slug dela. Se não, é 'particular'.
        $veiculo->slug_loja = $veiculo->user->revenda ? $veiculo->user->revenda->slug : 'particular';

        return $veiculo;
    });

    return view('loja.index', compact('veiculos','dadosAgrupados'));
}


    public function indexVeiculosNovos(Request $request)
{
    // Apenas chama a lógica sem filtros específicos iniciais
    return $this->processarBusca($request);
}

public function searchVeiculosNovos(Request $request)
{
    // Chama a mesma lógica, mas a URL será /veiculos-novos/pesquisa
    return $this->processarBusca($request);
}
// Listagem inicial de Semi-novos
public function indexVeiculosSemiNovos(Request $request)
{
    return $this->processarBusca($request, 'Semi-novo');
}

// Caso tenha uma rota de pesquisa específica para semi-novos
public function searchVeiculosSemiNovos(Request $request)
{
    return $this->processarBusca($request, 'Semi-novo');
}
public function indexVeiculosUsados(Request $request)
{
    return $this->processarBusca($request, 'Usado');
}

public function searchVeiculosUsados(Request $request)
{
    return $this->processarBusca($request, 'Usado');
}

private function processarBusca(Request $request, $estado = 'Novo')
{
    $query = Anuncio::with('user.revenda');

    // 1. REGRAS GLOBAIS
    $query->where('status', 'Ativo')
          ->where('status_anuncio', 'Publicado')
          ->where('estado', $estado);

    $veiculos = $query->orderBy('created_at', 'desc')->paginate(12);

    // Mapeamento de Marcas
    $mapeamentoMarcas = [
        'volkswagen' => 'VW',
        'chevrolet'  => 'CHEVROLET',
        'fiat'       => 'FIAT',
        'ford'       => 'FORD',
        'renault'    => 'RENAULT',
        'hyundai'    => 'HYUNDAI',
        'toyota'     => 'TOYOTA',
        'honda'      => 'HONDA'
    ];

    // Filtros de busca
    if ($request->filled('search') || $request->filled('marca')) {
        $termo = strtolower($request->search ?? $request->marca);
        $sigla = $mapeamentoMarcas[$termo] ?? $termo;
        $query->where('marca', 'LIKE', "%{$sigla}%");
    }

// --- AJUSTE DOS FILTROS DE ANO ---

// Damos prioridade total à FAIXA (De/Até). Se ela existir, ignoramos o botão individual 'ano'.
if ($request->filled('ano_de') || $request->filled('ano_ate')) {
    if ($request->filled('ano_de')) {
        $query->whereRaw('SUBSTRING_INDEX(ano, "/", 1) >= ?', [$request->ano_de]);
    }
    if ($request->filled('ano_ate')) {
        $query->whereRaw('SUBSTRING_INDEX(ano, "/", 1) <= ?', [$request->ano_ate]);
    }
} 
// Somente se não houver De/Até, verificamos o botão individual 'ano'
elseif ($request->filled('ano')) {
    $query->where('ano', 'LIKE', $request->ano . '%');
}
    // ---------------------------------

    // Outros filtros
    $query->when($request->tipo, fn($q, $t) => $q->where('tipo', $t));
    $query->when($request->min_price, fn($q, $min) => $q->where('valor', '>=', (float)$min));
    $query->when($request->max_price, fn($q, $max) => $q->where('valor', '<=', (float)$max));

    // Busca os anos disponíveis para o filtro lateral (para enviar para a view)
    $anosDisponiveis = Anuncio::where('status', 'Ativo')
        ->where('estado', $estado)
        ->selectRaw('DISTINCT SUBSTRING_INDEX(ano, "/", 1) as ano_simples')
        ->orderBy('ano_simples', 'desc')
        ->pluck('ano_simples');

    $veiculos = $query->orderBy('created_at', 'desc')->paginate(12);
    
    // Transformação para exibição
    $veiculos->getCollection()->transform(function ($veiculo) {
        $texto = $veiculo->marca;
        if (str_starts_with($texto, 'I/')) { $texto = substr($texto, 2); }
        
        if (str_contains($texto, '/')) {
            [$marca, $modelo] = explode('/', $texto, 2);
        } else {
            $partes = explode(' ', $texto, 2);
            $marca  = $partes[0] ?? '';
            $modelo = $partes[1] ?? '';
        }

        $veiculo->marca_exibicao  = trim($marca);
        $veiculo->modelo_exibicao = trim($modelo);
        // Limpa o ano para exibir apenas os 4 primeiros dígitos na listagem
        $veiculo->ano_exibicao = substr($veiculo->ano, 0, 4);
        
        return $veiculo;
    });

    $viewMap = [
        'Novo'      => 'loja.veiculos-novos',
        'Semi-novo' => 'loja.veiculos-semi-novos',
        'Usado'     => 'loja.veiculos-usados',
    ];

    $view = $viewMap[$estado] ?? 'loja.veiculos-novos';
    
    // Importante: Passar os $anosDisponiveis para a view
    return view($view, compact('veiculos', 'anosDisponiveis'));
}

public function show($slug_loja, $slug_veiculo) 
{
    // Agora buscamos pelo slug do VEÍCULO, que é o que importa
    $veiculo = Anuncio::where('slug', $slug_veiculo)->firstOrFail();
    
    $veiculo->images = json_decode($veiculo->images, true) ?? [];

    // ... (sua lógica de marcas e modelos que já existe) ...

    // --- BUSCAR DADOS DO VENDEDOR ---
    // Verificamos se o parâmetro na URL é 'particular'
    if ($slug_loja === 'particular') {
        $vendedor = \DB::table('particulares')->where('user_id', $veiculo->user_id)->first();
        $tipoVendedor = 'particular';
    } else {
        $vendedor = \DB::table('revendas')->where('slug', $slug_loja)->first();
        $tipoVendedor = 'revenda';
    }

    // Caso o anúncio tenha sido movido ou o slug da loja mude
    if (!$vendedor) {
        // Fallback: tenta buscar de qualquer forma pelo dono do veículo
        $vendedor = \DB::table('revendas')->where('user_id', $veiculo->user_id)->first() 
                    ?? \DB::table('particulares')->where('user_id', $veiculo->user_id)->first();
    }

    if ($vendedor && isset($vendedor->fones)) {
        $vendedor->fones = json_decode($vendedor->fones, true);
    }

    return view('loja.revenda.detalhes', compact('veiculo', 'vendedor', 'tipoVendedor'));
}


public function buscarSugestoes(Request $request)
{
    $termo = $request->get('termo');

    if (empty($termo)) {
        return response()->json([]);
    }

    // Buscamos apenas os dados necessários para a sugestão
    $sugestoes = \App\Models\Anuncio::query()
        ->where('status', 'Ativo')
        ->where('status_anuncio', 'Publicado')
        ->where(function($q) use ($termo) {
            $q->where('marca_real', 'LIKE', "%{$termo}%")
              ->orWhere('modelo_real', 'LIKE', "%{$termo}%");
        })
        ->select('marca_real', 'modelo_real')
        ->distinct()
        ->limit(10)
        ->get();

    // RETORNA JSON (Essencial para o AJAX funcionar)
    return response()->json($sugestoes);
}

public function searchGeral(Request $request)
{
    $query = Anuncio::query();

    // 1. Filtro Global: Apenas anúncios PUBLICADOS e veículos ATIVOS
    $query->where('status_anuncio', 'Publicado')
          ->where('status', 'Ativo');

    // 2. Dados dinâmicos para preencher os filtros da View
    // Buscamos apenas o que está publicado para não mostrar marcas de carros offline
    $dadosAgrupados = Anuncio::where('status_anuncio', 'Publicado')
        ->where('status', 'Ativo')
        ->select('marca_real', 'modelo_real')
        ->get()
        ->groupBy('marca_real')
        ->map(fn($itens) => $itens->pluck('modelo_real')->unique()->values());

    $anosDisponiveis = Anuncio::where('status_anuncio', 'Publicado')
        ->whereNotNull('ano')
        ->selectRaw('DISTINCT LEFT(ano, 4) as ano_fabricacao')
        ->orderBy('ano_fabricacao', 'desc')
        ->pluck('ano_fabricacao');

    // 3. Aplicação dos Filtros da Request
    if ($request->filled('marca')) {
        $marcaBusca = strtoupper($request->marca);
        // Tratamento para VW vindo do filtro
        if ($marcaBusca === 'VW') $marcaBusca = 'VOLKSWAGEN';
        
        $query->where('marca_real', $marcaBusca);
    }

    if ($request->filled('modelo')) {
        $query->where('modelo_real', strtoupper($request->modelo));
    }

    if ($request->filled('ano')) {
        $query->where('ano', 'like', $request->ano . '%');
    }

    if ($request->filled('valor')) {
        $query->where('valor', '<=', $request->valor);
    }

    // 4. Execução da busca
    $veiculos = $query->orderBy('created_at', 'desc')->paginate(12);

    return view('loja.busca-resultados', compact('veiculos', 'dadosAgrupados', 'anosDisponiveis'));
}

}
