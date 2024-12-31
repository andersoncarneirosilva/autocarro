<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ordems')->insert([
            [
                'cliente_id' => 1,
                'tipo_servico' => 'Licenciamento',
                'servico' => 'Renovação do licenciamento anual do veículo.',
                'valor_total' => 350.00,
                'prazo' => '2024-01-15',
                'classe_status' => 'class',
                'status' => 'pendente',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
