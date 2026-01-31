<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\InfracoesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportarInfracoes extends Command
{
    protected $signature = 'alcecar:importar-infracoes';
    protected $description = 'Importa infrações com logs de depuração';

    public function handle()
{
    // Remove o limite de memória para este processo
    ini_set('memory_limit', '-1');
    set_time_limit(0);

    $path = storage_path('app/infracoes.xlsx');
    $this->info("Iniciando importação forçada...");

    try {
        \Maatwebsite\Excel\Facades\Excel::import(new InfracoesImport, $path);
        
        $total = \App\Models\Infracao::count();
        $this->info("Finalizado! Total no banco: {$total}");
    } catch (\Exception $e) {
        $this->error("Erro: " . $e->getMessage());
        // Se der erro de "Aba", tente forçar a aba 0 ou 1:
        // \Maatwebsite\Excel\Facades\Excel::import(new InfracoesImport, $path, null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
}