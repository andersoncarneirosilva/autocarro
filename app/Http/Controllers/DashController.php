<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DashModel;
use App\Models\Event;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\VeiculoGasto;
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
    $totalAtivos = Veiculo::where('empresa_id', $empresaId)->where('status', 'Disponível')->count();

    // 2. Vendidos e Receita (Filtrando por empresa_id)
    $totalVendidos = Veiculo::where('empresa_id', $empresaId)->where('status', 'Vendido')->count();
    $receitaVendas = Veiculo::where('empresa_id', $empresaId)->where('status', 'Vendido')->sum('valor_venda');

    // 3. Outros Totais (Filtrando por empresa_id)
    $totalArquivados = Veiculo::where('empresa_id', $empresaId)->where('status', 'Arquivado')->count();
    $totalClientes = Cliente::where('empresa_id', $empresaId)->count();
    $valorEstoque = Veiculo::where('empresa_id', $empresaId)->where('status', 'Disponível')->sum('valor');
    $ultimosVeiculos = Veiculo::where('empresa_id', $empresaId)->latest()->take(5)->get();

    $totalGastos = VeiculoGasto::sum('valor');
$quantidadeGastos = VeiculoGasto::count();

// Apenas o que ainda não foi pago (pago = 0 ou '0')
$contasAPagar = VeiculoGasto::where('pago', '0')->sum('valor');
$quantidadePendente = VeiculoGasto::where('pago', '0')->count();


    return view('dashboard.index', compact(
        'totalAtivos', 
        'totalVendidos',
        'receitaVendas',
        'totalArquivados', 
        'totalClientes', 
        'valorEstoque',
        'ultimosVeiculos','totalGastos', 'quantidadeGastos','contasAPagar','quantidadePendente'
    ));
}
}
