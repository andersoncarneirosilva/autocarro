<?php
namespace App\Http\Controllers;

use App\Models\Revenda;
use Illuminate\Http\Request;

class RevendaController extends Controller
{
    public function index()
    {
        $revendas = Revenda::orderBy('nome', 'asc')->get();
        return view('loja.revendas.index', compact('revendas'));
    }

    // Exibe o estoque de uma revenda específica
    public function show($slug)
    {
        $revenda = Revenda::where('slug', $slug)->firstOrFail();

        // Filtra apenas anúncios ativos e publicados desta revenda específica
        $veiculos = Anuncio::where('user_id', $revenda->user_id)
                            ->where('status', 'Ativo')
                            ->where('status_anuncio', 'Publicado')
                            ->orderBy('created_at', 'desc')
                            ->paginate(9);

        // Busca anos para o filtro lateral
        $anosDisponiveis = Anuncio::where('user_id', $revenda->user_id)
            ->where('status_anuncio', 'Publicado')
            ->whereNotNull('ano')
            ->selectRaw('DISTINCT LEFT(ano, 4) as ano_fabricacao')
            ->orderBy('ano_fabricacao', 'desc')
            ->pluck('ano_fabricacao');

        return view('loja.revenda.index', compact('revenda', 'veiculos', 'anosDisponiveis'));
    }
}
