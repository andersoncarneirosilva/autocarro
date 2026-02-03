<?php

namespace App\Http\Controllers\Api;

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
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;
    
    $data = [
        'totalAtivos' => Veiculo::where('empresa_id', $empresaId)->where('status', 'Disponível')->count(),
        'totalVendidos' => Veiculo::where('empresa_id', $empresaId)->where('status', 'Vendido')->count(),
        'receitaVendas' => Veiculo::where('empresa_id', $empresaId)->where('status', 'Vendido')->sum('valor_venda'),
        'valorEstoque' => Veiculo::where('empresa_id', $empresaId)->where('status', 'Disponível')->sum('valor'),
        'ultimosVeiculos' => Veiculo::where('empresa_id', $empresaId)->latest()->take(5)->get(),
        'contasAPagar' => VeiculoGasto::where('pago', '0')->sum('valor'),
        'quantidadePendente' => VeiculoGasto::where('pago', '0')->count(),
    ];

    return new DashboardResource($data);
}
}
