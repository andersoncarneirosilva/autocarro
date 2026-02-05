<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DashboardResource;
use App\Http\Controllers\Controller;
use App\Models\DashModel;
use App\Models\Veiculo;
use App\Models\VeiculoGasto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendNotificationStorageJob;
use App\Http\Resources\VeiculoResource;

class ApiDashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function getDashboardData()
{
    // Definimos os status que consideramos "em estoque"
    $statusAtivos = ['Ativo', 'Disponível', 'disponível'];

    $ativos = Veiculo::withoutGlobalScopes()
        ->whereIn('status', $statusAtivos)
        ->get();

    $data = [
        'totalAtivos'        => $ativos->count(),
        'totalVendidos'      => Veiculo::withoutGlobalScopes()->where('status', 'Vendido')->count(),
        'receitaVendas'      => (float) Veiculo::withoutGlobalScopes()->where('status', 'Vendido')->sum('valor_venda'),
        'valorEstoque'       => (float) $ativos->sum('valor'),
        
        // Agora filtrando apenas os ativos para a lista recente:
        'ultimosVeiculos'    => VeiculoResource::collection(
            Veiculo::withoutGlobalScopes()
                ->whereIn('status', $statusAtivos) // Filtro adicionado aqui
                ->latest()
                ->take(5)
                ->get()
        ),
        
        'contasAPagar'       => (float) VeiculoGasto::withoutGlobalScopes()->where('pago', '0')->sum('valor'),
        'quantidadePendente' => (int) VeiculoGasto::withoutGlobalScopes()->where('pago', '0')->count(),
    ];

    return new DashboardResource($data);
}
}
