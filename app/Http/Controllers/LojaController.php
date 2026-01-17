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

    // Filtros de busca (Mantendo sua lógica existente)
    if ($request->filled('search') || $request->filled('marca')) {
        $termo = strtolower($request->search ?? $request->marca);
        $sigla = $mapeamentoMarcas[$termo] ?? $termo;
        $query->where('marca', 'LIKE', "%{$sigla}%");
    }

    // Outros filtros
    $query->when($request->tipo, fn($q, $t) => $q->where('tipo', $t));
    $query->when($request->min_price, fn($q, $min) => $q->where('valor', '>=', (float)$min));
    $query->when($request->max_price, fn($q, $max) => $q->where('valor', '<=', (float)$max));
    $query->when($request->ano_de, fn($q, $ano) => $q->where('ano', 'LIKE', "{$ano}%"));

    $veiculos = $query->orderBy('created_at', 'desc')->paginate(12);
    
    // 2. APLICA A TRANSFORMAÇÃO DE MARCA/MODELO (Sua lógica de limpeza)
    $veiculos->getCollection()->transform(function ($veiculo) {
        $texto = $veiculo->marca;
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

        $veiculo->marca_exibicao  = trim($marca);
        $veiculo->modelo_exibicao = trim($modelo);
        return $veiculo;
    });

    // Define qual view retornar baseado no estado
    $viewMap = [
        'Novo'      => 'loja.veiculos-novos',
        'Semi-novo' => 'loja.veiculos-semi-novos',
        'Usado'     => 'loja.veiculos-usados',
    ];

    $view = $viewMap[$estado] ?? 'loja.veiculos-novos';
    
    return view($view, compact('veiculos'));
}

public function show($slug)
{
    // 1. Busca pelo slug em vez do ID
    $veiculo = Anuncio::where('slug', $slug)->firstOrFail();

    // 2. Decodifica as imagens (JSON para Array)
    $veiculo->images = json_decode($veiculo->images, true) ?? [];

    // 3. Lógica de tratamento de Marca e Modelo
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

    $veiculo->marca_exibicao  = trim($marca);
    $veiculo->modelo_exibicao = trim($modelo);

    // 4. Mapa de Background conforme a marca
    $mapaBackground = [
        'FORD'    => 'assets/brands/ford.jpg',
        'FIAT'    => 'assets/brands/fiat.jpg',
        'HONDA'   => 'assets/brands/honda.jpg',
        'YAMAHA'  => 'assets/brands/yamaha.jpg',
        'RENAULT' => 'assets/brands/renault.jpg',
    ];

    $marcaUpper = strtoupper($veiculo->marca_exibicao);

    $veiculo->background_image = asset(
        $mapaBackground[$marcaUpper] ?? 'assets/brands/default.jpg'
    );

    return view('loja.detalhes', compact('veiculo'));
}

public function contato()
{
    return view('loja.contato');
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
    $termo = $request->get('termo');

    $veiculos = \App\Models\Anuncio::query()
        ->where('status', 'Ativo')
        ->where('status_anuncio', 'Publicado')
        ->when($termo, function($query) use ($termo) {
            $query->where(function($q) use ($termo) {
                $q->where('marca_real', 'LIKE', "%{$termo}%")
                  ->orWhere('modelo_real', 'LIKE', "%{$termo}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    // Retorna para a view de resultados (ou você pode reutilizar a de novos/usados)
    return view('loja.busca-resultados', compact('veiculos', 'termo'));
}

}
