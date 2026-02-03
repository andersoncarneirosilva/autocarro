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
    // O Global Scope da Trait já vai aplicar o where('empresa_id', ...) automaticamente!
    $data = [
        'totalAtivos' => Veiculo::where('status', 'Disponível')->count(),
        'totalVendidos' => Veiculo::where('status', 'Vendido')->count(),
        'receitaVendas' => (float) Veiculo::where('status', 'Vendido')->sum('valor_venda'),
        'valorEstoque' => (float) Veiculo::where('status', 'Disponível')->sum('valor'),
        'ultimosVeiculos' => Veiculo::latest()->take(5)->get(),
        'contasAPagar' => (float) VeiculoGasto::where('pago', '0')->sum('valor'),
        'quantidadePendente' => (int) VeiculoGasto::where('pago', '0')->count(),
    ];

    return new DashboardResource($data);
}
}
