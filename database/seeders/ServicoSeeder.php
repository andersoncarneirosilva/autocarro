<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Certifique-se de que o namespace está correto
use App\Models\Servico; // Importa o modelo Servico

class ServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servico::create([
            'nome_servico' => 'Licenciamento',
            'valor_servico' => 120,
            'taxa_servico' => 15,
        ]);
    }
}
