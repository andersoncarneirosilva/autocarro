<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Procuracao;

class ProcuracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Procuracao::create([
            'nome' => 'Anderson',
            'endereco' => 'Rua Sao Joao, 30',
            'cpf' => '013.887.090-07',
            'marca' => 'Fiat',
            'placa' => 'IPJ-8625',
            'chassi' => '2A5D8R4G18R58G25D',
            'cor' => 'Azul',
            'ano' => '2022',
            'modelo' => '2023',
            'renavam' => '10805414635',
            'arquivo_doc' => 'test.pdf',
            'arquivo_proc' => 'test.pdf',
        ]);
    }
}
