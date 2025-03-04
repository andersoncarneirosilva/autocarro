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

    public function index(Request $request)
    {
        // dd(auth()->user());
        // abort(404);
        $events = Event::all();
        // dd($event);
        $search = $request->search;

        $userId = Auth::id();
        $user = User::find($userId);

        // Contagem de veículos cadastrados
        $veiculosCount = $user->veiculos()->count();
        $crlvCount = Veiculo::where('user_id', Auth::id())
            ->whereNotNull('arquivo_doc')
            ->where('arquivo_doc', '!=', '0')
            ->count();

        $procCount = Veiculo::where('user_id', Auth::id())
            ->whereNotNull('arquivo_proc_assinado')
            ->where('arquivo_proc_assinado', '!=', '0')
            ->count();

        $atpveCount = Veiculo::where('user_id', Auth::id())
            ->whereNotNull('arquivo_atpve_assinado')
            ->where('arquivo_atpve_assinado', '!=', '0')
            ->count();

        $clientesCount = $user->clientes()->count();

        $assinatura = $user->assinaturas()->latest()->first();

        if ($user->plano == 'Padrão' || $user->plano == 'Pro') {
            if (! $assinatura || now()->gt($assinatura->data_fim) || $assinatura->status == 'pending') {
                return redirect()->route('assinatura.expirada')->with('error', 'Sua assinatura expirou.');
            }
        }

        $emprestimos = Veiculo::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $clientes = Cliente::where('user_id', $userId)->get();

        // dd($emprestimos);
        // $users = $this->model->getUsersDash();
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

        // Caminho para a pasta de documentos
        $path = storage_path("app/public/documentos/usuario_{$userId}");

        // Função para calcular o tamanho total da pasta
        function getFolderSize($folder)
        {
            $size = 0;
            foreach (glob(rtrim($folder, '/').'/*', GLOB_NOSORT) as $file) {
                $size += is_file($file) ? filesize($file) : getFolderSize($file);
            }

            return $size;
        }

        // Calcular o tamanho usado na pasta
        $usedSpaceInBytes = getFolderSize($path);
        $usedSpaceInMB = $usedSpaceInBytes / (1024 * 1024); // Converter para MB
        //dd($usedSpaceInMB);
        $limitInMB = $user->size_folder; // Limite de MB do usuario
        //dd($limitInMB);
        $percentUsed = ($usedSpaceInMB / $limitInMB) * 100; // Percentual usado
        //dd($percentUsed);
        
        // Verifica se já existe uma notificação nos últimos 24h
        $lastNotification = $user->notifications()
        ->where('type', 'App\Notifications\StorageWarningNotification') // Tipo específico
        ->where('created_at', '>=', now()->subDay()) // Últimas 24h
        ->exists();

        if ($percentUsed >= 80 && !$lastNotification) {
        dispatch(new SendNotificationStorageJob($user, $percentUsed));
        \Log::debug('Notificação enviada para o usuário: ' . $user->email);
        }

        // Passar as informações para a view
        return view('dashboard.index', compact(['countDocs',
            'countProcs',
            'countOrder',
            'countCnh',
            'clientes',
            'emprestimos',
            'today',
            'totalOrdensAtual',
            'totalOrdensAnterior',
            'porcentagem',
            'usedSpaceInMB',
            'percentUsed',
            'limitInMB',
            'events',
            'crlvCount',
            'procCount',
            'atpveCount',
            'clientesCount',
            'veiculosCount'
        ]));
    }
}
