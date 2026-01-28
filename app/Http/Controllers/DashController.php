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
    $userId = auth()->id();

    // Veículos
    $totalAtivos = Veiculo::where('user_id', $userId)->where('status', 'Ativo')->count();

    // NOVO: Contagem de Vendidos e Total de Receita
    $totalVendidos = Veiculo::where('user_id', $userId)->where('status', 'Vendido')->count();
    $receitaVendas = Veiculo::where('user_id', $userId)->where('status', 'Vendido')->sum('valor_venda');

    $totalArquivados = Veiculo::where('user_id', $userId)->where('status', 'Arquivado')->count();
    $totalClientes = Cliente::where('user_id', $userId)->count();
    $valorEstoque = Veiculo::where('user_id', $userId)->where('status', 'Ativo')->sum('valor');
    $ultimosVeiculos = Veiculo::where('user_id', $userId)->latest()->take(5)->get();

    // Multas - Ajustado para pegar apenas multas dos veículos do usuário logado
    $totalMultasPendente = Multa::whereHas('veiculo', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', '!=', 'pago')->sum('valor');

    $qtdMultasVencidas = Multa::whereHas('veiculo', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', '!=', 'pago')
          ->where('data_vencimento', '<', now())
          ->count();
    
    $multasCriticas = Multa::with('veiculo')
        ->whereHas('veiculo', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', '!=', 'pago')
        ->orderBy('data_vencimento', 'asc')
        ->take(5)
        ->get();

    // Retornando tudo solto no compact (mais simples)
    return view('dashboard.index', compact(
        'totalAtivos', 
        'totalVendidos', // Adicionado
        'receitaVendas', // Adicionado
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
