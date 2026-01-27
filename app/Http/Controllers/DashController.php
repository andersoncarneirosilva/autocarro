<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DashModel;
use App\Models\Event;
use App\Models\User;
use App\Models\Veiculo;
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
    // Obtém o ID do usuário logado
    $userId = auth()->id();

    // Contagem de veículos ativos do usuário
    $totalAtivos = Veiculo::where('user_id', $userId)
        ->where('status', 'Ativo')
        ->count();

    // Contagem de veículos arquivados do usuário
    $totalArquivados = Veiculo::where('user_id', $userId)
        ->where('status', 'Arquivado')
        ->count();

    // Contagem total de clientes do usuário
    $totalClientes = Cliente::where('user_id', $userId)
        ->count();

    // Soma do valor de venda de todos os veículos ativos do usuário
    $valorEstoque = Veiculo::where('user_id', $userId)
        ->where('status', 'Ativo')
        ->sum('valor');

    $ultimosVeiculos = Veiculo::where('user_id', $userId)
    ->latest() // Ordena pelos mais recentes
    ->take(5)  // Limita a 5 registros
    ->get();

    return view('dashboard.index', compact(
        'totalAtivos', 
        'totalArquivados', 
        'totalClientes', 
        'valorEstoque',
        'ultimosVeiculos'
    ));
}
}
