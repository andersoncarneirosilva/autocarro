<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anuncio; 

class RevendaPublicaController extends Controller
{
    public function show($slug)
{
    // 1. Busca a revenda
    $revenda = DB::table('revendas')->where('slug', $slug)->first();

    if (!$revenda) {
        abort(404); 
    }

    // 2. Busca anos disponíveis (apenas desta revenda para ser mais preciso)
    $anosDisponiveis = Anuncio::where('user_id', $revenda->user_id)
        ->where('status_anuncio', 'Publicado')
        ->whereNotNull('ano')
        ->selectRaw('DISTINCT LEFT(ano, 4) as ano_fabricacao')
        ->orderBy('ano_fabricacao', 'desc')
        ->pluck('ano_fabricacao');

    // 3. Busca os anúncios COM PAGINAÇÃO
    // Use paginate(9) para mostrar 3 colunas por 3 linhas
    $veiculos = Anuncio::where('user_id', $revenda->user_id)
                        ->where('status', 'Ativo')
                        ->orderBy('created_at', 'desc')
                        ->paginate(9); // <--- MUDANÇA AQUI

    return view('loja.revenda.index', compact('revenda', 'veiculos', 'anosDisponiveis'));
}

public function detalhesVeiculo($loja_slug, $veiculo_slug)
{
    // 1. Busca a revenda pelo slug para manter o contexto (logo, cores, contato)
    $revenda = DB::table('revendas')->where('slug', $loja_slug)->first();

    if (!$revenda) {
        abort(404, 'Loja não encontrada');
    }

    // 2. Busca o anúncio pelo slug E garante que ele pertença ao dono daquela revenda
    $veiculo = Anuncio::where('slug', $veiculo_slug)
                      ->where('user_id', $revenda->user_id)
                      ->where('status', 'Ativo')
                      ->first();

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

    if (!$veiculo) {
        abort(404, 'Veículo não encontrado nesta loja');
    }

    // 3. Retorna a view de detalhes (ex: anuncios.show ou revendas.veiculo)
    return view('loja.revenda.detalhes', compact('revenda', 'veiculo'));
}
}