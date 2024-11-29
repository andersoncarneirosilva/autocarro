<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class VerificarParcelaVencida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'VerificarParcelaVencida:verificar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para verificar se tem parcela vencida hoje';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Log::info("VERIFICANDO PARCELAS");
        $dataAtual = Carbon::now();

        $parcelas = \DB::table('parcelas')->whereDate('vencimento_at', '<=', date('Y-m-d'))
                                            ->where('status', 'PENDENTE')
                                            ->get();
        //dd($parcelas);
        foreach ($parcelas as $parcela) {
            \DB::table('parcelas')->where('id', $parcela->id)->update([
                'status' => 'ATRASADO',
                'class_status' => 'badge badge-outline-danger',
            ]);
            
        }
    }
}
