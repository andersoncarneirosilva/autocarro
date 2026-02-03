<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DashboardResource;
use App\Http\Controllers\Controller;
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

class ApiDashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function getDashboardData()
{
    // Usamos o status que está no seu banco: 'Ativo' e 'Disponível'
    $data = [
        // Conta tanto 'Ativo' quanto 'Disponível'
        'totalAtivos' => Veiculo::withoutGlobalScopes()
            ->whereIn('status', ['Ativo', 'Disponível'])
            ->count(),
            
        'totalVendidos' => Veiculo::withoutGlobalScopes()
            ->where('status', 'Vendido')
            ->count(),
            
        'receitaVendas' => (float) Veiculo::withoutGlobalScopes()
            ->where('status', 'Vendido')
            ->sum('valor_venda'),
            
        'valorEstoque' => (float) Veiculo::withoutGlobalScopes()
            ->whereIn('status', ['Ativo', 'Disponível'])
            ->sum('valor'),
            
        'ultimosVeiculos' => Veiculo::withoutGlobalScopes()
            ->latest()
            ->take(5)
            ->get(),
            
        'contasAPagar' => (float) VeiculoGasto::withoutGlobalScopes()
            ->where('pago', '0')
            ->sum('valor'),
            
        'quantidadePendente' => (int) VeiculoGasto::withoutGlobalScopes()
            ->where('pago', '0')
            ->count(),
    ];

    return new DashboardResource($data);
}
}
