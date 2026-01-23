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
    //abort(500);
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
    // 1. Busca a revenda pelo slug
    $revenda = DB::table('revendas')->where('slug', $loja_slug)->first();

    if (!$revenda) {
        abort(404, 'Loja não encontrada');
    }

    // 2. Busca o anúncio
    $veiculo = Anuncio::where('slug', $veiculo_slug)
                      ->where('status', 'Ativo')
                      ->first();

    if (!$veiculo) {
        abort(404, 'Veículo não encontrado nesta loja');
    }

    // 3. Processamento de marcas/modelos
    $texto = $veiculo->marca;
    $marca = ''; $modelo = '';

    if (str_starts_with($texto, 'I/')) { $texto = substr($texto, 2); }

    if (str_contains($texto, '/')) {
        [$marca, $modelo] = explode('/', $texto, 2);
    } else {
        $partes = explode(' ', $texto, 2);
        $marca  = $partes[0] ?? '';
        $modelo = $partes[1] ?? '';
    }

    $traducoes = ['VW' => 'VOLKSWAGEN', 'GM' => 'CHEVROLET'];
    $marcaLimpa = strtoupper(trim($marca));
    $veiculo->marca_exibicao = $traducoes[$marcaLimpa] ?? $marcaLimpa;
    $veiculo->modelo_exibicao = trim($modelo);

    // --- PROCESSAMENTO DO WHATSAPP (Lógica simplificada para o Alcecar) ---
    $fones = json_decode($revenda->fones, true);
    $whatsapp = $fones['whatsapp'] ?? '';
    
    // O texto da mensagem automática
    $textoWhats = "Olá! Vi o anúncio do {$veiculo->marca_exibicao} {$veiculo->modelo_exibicao} no Alcecar e gostaria de mais informações.";
    
    // Monta a URL final - Como o número já está limpo, apenas concatenamos
    $revenda->whatsapp_url = "https://wa.me/55" . $whatsapp . "?text=" . urlencode($textoWhats);

    // --- PROCESSAMENTO DO MAPS ---
    $endereco = "{$revenda->rua}, {$revenda->numero}, {$revenda->bairro}, {$revenda->cidade}-{$revenda->estado}";
    $revenda->maps_url = "https://www.google.com/maps/search/?api=1&query=" . urlencode($endereco);

    return view('loja.revenda.detalhes', compact('revenda', 'veiculo'));
}
}