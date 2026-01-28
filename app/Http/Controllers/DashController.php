<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DashModel;
use App\Models\Event;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\Multa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendNotificationStorageJob;

class DashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index()
{
    $user = Auth::user();
    // LÓGICA ALCECAR: Define qual empresa estamos filtrando
    $empresaId = $user->empresa_id ?? $user->id;
    
    // 1. Veículos (Filtrando por empresa_id)
    $totalAtivos = Veiculo::where('empresa_id', $empresaId)->where('status', 'Ativo')->count();

    // 2. Vendidos e Receita (Filtrando por empresa_id)
    $totalVendidos = Veiculo::where('empresa_id', $empresaId)->where('status', 'Vendido')->count();
    $receitaVendas = Veiculo::where('empresa_id', $empresaId)->where('status', 'Vendido')->sum('valor_venda');

    // 3. Outros Totais (Filtrando por empresa_id)
    $totalArquivados = Veiculo::where('empresa_id', $empresaId)->where('status', 'Arquivado')->count();
    $totalClientes = Cliente::where('empresa_id', $empresaId)->count();
    $valorEstoque = Veiculo::where('empresa_id', $empresaId)->where('status', 'Ativo')->sum('valor');
    $ultimosVeiculos = Veiculo::where('empresa_id', $empresaId)->latest()->take(5)->get();

    // 4. Multas (Ajustado para empresa_id dentro do relacionamento com veículo)
    $totalMultasPendente = Multa::whereHas('veiculo', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId); // Alterado de user_id para empresa_id
        })->where('status', '!=', 'pago')->sum('valor');

    $qtdMultasVencidas = Multa::whereHas('veiculo', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId); // Alterado de user_id para empresa_id
        })->where('status', '!=', 'pago')
          ->where('data_vencimento', '<', now())
          ->count();
    
    $multasCriticas = Multa::with('veiculo')
        ->whereHas('veiculo', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId); // Alterado de user_id para empresa_id
        })
        ->where('status', '!=', 'pago')
        ->orderBy('data_vencimento', 'asc')
        ->take(5)
        ->get();

    return view('dashboard.index', compact(
        'totalAtivos', 
        'totalVendidos',
        'receitaVendas',
        'totalArquivados', 
        'totalClientes', 
        'valorEstoque',
        'ultimosVeiculos',
        'totalMultasPendente',
        'qtdMultasVencidas',
        'multasCriticas'
    ));
}
}
