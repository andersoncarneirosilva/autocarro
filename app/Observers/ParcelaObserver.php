<?php

namespace App\Observers;

use App\Models\Emprestimo;
use App\Models\Parcela;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class ParcelaObserver
{
    /**
     * Handle the Parcela "created" event.
     */
    public function created(Parcela $parcela): void
    {
        //
        //Log::info("Parcela sendo criada");
    }

    /**
     * Handle the Parcela "updated" event.
     */
    public function updated(Parcela $parcela): void
    {
        
        
        $conta = Parcela::where('emprestimo_id', $parcela->emprestimo_id)
                ->where('status', 'PENDENTE')
                ->orWhere('status', 'ATRASADO')
                ->count();

        if($conta == 0){
            $emprestimo = Emprestimo::where('id', $parcela->emprestimo_id)->first();
            if($emprestimo){
            $emprestimo->fill([
                'status' => 'PAGO',
                'class_status' => 'badge badge-success-lighten',
                ]);
                $emprestimo->save();
            }else{
                Log::info($emprestimo);
            }
                
        }
    }

    /**
     * Handle the Parcela "deleted" event.
     */
    public function deleted(Parcela $parcela): void
    {
        //
    }

    /**
     * Handle the Parcela "restored" event.
     */
    public function restored(Parcela $parcela): void
    {
        //
    }

    /**
     * Handle the Parcela "force deleted" event.
     */
    public function forceDeleted(Parcela $parcela): void
    {
        //
    }
}
