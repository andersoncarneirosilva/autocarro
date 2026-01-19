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
    $query = Anuncio::query()->where('status_anuncio', 'Publicado'); 

    // Executa a paginação após aplicar o filtro
    $veiculos = $query->paginate(10);

    // Ajusta marca e modelo apenas para exibição
    $veiculos->getCollection()->transform(function ($veiculo) {

        $texto = $veiculo->marca;

        if (str_starts_with($texto, 'I/')) {
            // Remove apenas o "I/"
            $texto = substr($texto, 2);

            // Caso raro: ainda ter "/"
            if (str_contains($texto, '/')) {
                [$marca, $modelo] = explode('/', $texto, 2);
            } else {
                $partes = explode(' ', $texto, 2);
                $marca  = $partes[0] ?? '';
                $modelo = $partes[1] ?? '';
            }
        } else {
            // Veículos normais
            if (str_contains($texto, '/')) {
                [$marca, $modelo] = explode('/', $texto, 2);
            } else {
                $partes = explode(' ', $texto, 2);
                $marca  = $partes[0] ?? '';
                $modelo = $partes[1] ?? '';
            }
        }

        // Campos somente para exibição
        $veiculo->marca_exibicao  = trim($marca);
        $veiculo->modelo_exibicao = trim($modelo);

        return $veiculo;
    });

    return view('loja.index', compact('veiculos'));
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

/**
 * Lógica centralizada de busca e listagem
 */
private function processarBusca(Request $request, $estado = 'Novo')
{
    $query = Anuncio::query();

    // 1. REGRAS GLOBAIS
    $query->where('status', 'Ativo')
          ->where('status_anuncio', 'Publicado')
          ->where('estado', $estado);

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

public function show($slug)
{
    $veiculo = Anuncio::where('slug', $slug)->firstOrFail();
    $veiculo->images = json_decode($veiculo->images, true) ?? [];

    $texto = $veiculo->marca;
    $marca = '';
    $modelo = '';

    if (str_starts_with($texto, 'I/')) {
        $texto = substr($texto, 2);
    }

    if (str_contains($texto, '/')) {
        [$marca, $modelo] = explode('/', $texto, 2);
    } else {
        $partes = explode(' ', $texto, 2);
        $marca  = $partes[0] ?? '';
        $modelo = $partes[1] ?? '';
    }

    // --- NOVA LÓGICA DE TRADUÇÃO DE MARCAS ---
    $traducoes = [
        'VW' => 'VOLKSWAGEN',
        'GM' => 'CHEVROLET',
    ];

    $marcaLimpa = strtoupper(trim($marca));
    
    // Se a marca estiver no dicionário, substitui. Se não, mantém a original.
    $veiculo->marca_exibicao = $traducoes[$marcaLimpa] ?? $marcaLimpa;
    $veiculo->modelo_exibicao = trim($modelo);

    // --- MAPA DE BACKGROUND ---
    $mapaBackground = [
        'FORD'       => 'layout/images/brands/ford.jpg',
        'FIAT'       => 'layout/images/brands/fiat.jpg',
        'HONDA'      => 'layout/images/brands/honda.jpg',
        'YAMAHA'     => 'layout/images/brands/yamaha.jpg',
        'RENAULT'    => 'layout/images/brands/renault.jpg',
        'VOLKSWAGEN' => 'layout/images/brands/volkswagen.jpg',
        'CHEVROLET'  => 'layout/images/brands/chevrolet.jpg',
    ];

    // Agora usamos a marca já traduzida para buscar o background
    $veiculo->background_image = asset(
        $mapaBackground[$veiculo->marca_exibicao] ?? 'layout/images/brands/default.jpg'
    );

    return view('loja.detalhes', compact('veiculo'));
}

public function contato()
{
    return view('loja.contato');
}

// public function site()
// {
//     return view('site.index');
// }

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
    // Inicia a query
    $query = Anuncio::query();

    // Filtro de Marca
    if ($request->filled('marca')) {
        $query->where('marca', $request->marca);
    }

    // Filtro de Modelo
    if ($request->filled('modelo')) {
        $query->where('modelo', $request->modelo);
    }

    // Filtro de Ano (Maior ou igual ao selecionado)
    if ($request->filled('ano')) {
        $query->where('ano', '>=', $request->ano);
    }

    // Filtro de Preço (Até o valor selecionado)
    if ($request->filled('preco')) {
        $query->where('preco', '<=', $request->preco);
    }

    // Busca os resultados (com paginação se desejar)
    $veiculos = $query->where('status', 'disponivel')->paginate(12);

    return view('loja.busca-resultados', compact('veiculos'));
}

}
