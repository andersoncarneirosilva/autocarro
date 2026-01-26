<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DashModel;
use App\Models\Event;
use App\Models\User;
use App\Models\Anuncio;
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
    $query = Anuncio::where('user_id', Auth::id());

    $totalEstoque = (clone $query)->where('status', 'ATIVO')->count();
    $valorTotal   = (clone $query)->where('status', 'ATIVO')->sum('valor');
    $totalVisitas = (clone $query)->sum('visitas');
    $totalOfertas = (clone $query)->whereNotNull('valor_oferta')->where('valor_oferta', '>', 0)->count();

    // Busca os 5 veículos com mais visitas do usuário logado
    $maisVistos = Anuncio::where('user_id', Auth::id())
    ->orderBy('visitas', 'desc')
    ->limit(5)
    ->get();

    $maxVisitas = $maisVistos->max('visitas') ?? 0;
        
    $distribuicao = Anuncio::where('user_id', Auth::id())
    ->select('combustivel', \DB::raw('count(*) as total'))
    ->groupBy('combustivel')
    ->get();

    $categorias = Anuncio::where('user_id', Auth::id())
    ->select('modelo_carro', \DB::raw('count(*) as total'))
    ->whereNotNull('modelo_carro')
    ->groupBy('modelo_carro')
    ->get();

    return view('dashboard.index', compact(
        'totalEstoque', 
        'valorTotal', 
        'totalVisitas', 
        'totalOfertas',
        'maisVistos',
        'maxVisitas',
        'distribuicao',
        'categorias'
    ));
}
}
