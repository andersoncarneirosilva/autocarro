<?php

namespace App\Http\Controllers;

use App\Models\DashModel;
use App\Models\Procuracao;
use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index(Request $request){
        //dd(auth()->user());

        $search = $request->search;
        $emprestimos = Veiculo::orderBy('created_at', 'desc')->take(4)->get();
        //$users = $this->model->getUsersDash();
        $countDocs = $this->model->getCountDocs();
        $countProcs = $this->model->getCountProcs();
        $countOrder = $this->model->getCountOrdens();
        $countCnh = 12;

        // Pega o mês e ano atual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Pega o mês e ano do mês anterior
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        // Soma o valor total da coluna "valor" na tabela "ordens" para o mês atual
        $totalOrdensAtual = DB::table('ordems')
                                    ->whereMonth('created_at', $currentMonth)
                                    ->whereYear('created_at', $currentYear)
                                    ->where('status', 'PAGO')
                                    ->sum('valor_total');


        // Soma o valor total da coluna "valor" na tabela "ordens" para o mês anterior
        $totalOrdensAnterior = DB::table('ordems')
                                    ->whereMonth('created_at', $previousMonth)
                                    ->whereYear('created_at', $previousYear)
                                    ->sum('valor_total');

        // Calcula a porcentagem de crescimento ou queda entre o mês atual e o mês anterior
        $porcentagem = 0;
        if ($totalOrdensAnterior > 0) {
            $porcentagem = (($totalOrdensAtual - $totalOrdensAnterior) / $totalOrdensAnterior) * 100;
        }

        $porcentagem = number_format($porcentagem, 2);

        \Carbon\Carbon::setLocale('pt_BR'); // Define o idioma do Carbon
        $today = Carbon::now()->translatedFormat('d \d\e F \d\e Y'); // Exemplo: "02 de janeiro de 2025"
        
        //return view('sua-view', compact('today'));

        return view('dashboard.index', compact(['countDocs', 
                                                'countProcs', 
                                                'countOrder', 
                                                'countCnh', 
                                                'emprestimos', 
                                                'today', 
                                                'totalOrdensAtual',
                                                'totalOrdensAnterior',
                                                'porcentagem']));
    }
}