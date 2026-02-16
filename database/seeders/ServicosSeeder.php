<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servico;
use Illuminate\Support\Facades\DB;

class ServicosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa a tabela antes de inserir para não duplicar se rodar duas vezes
        // Desative as chaves estrangeiras temporariamente para evitar erros no truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Servico::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $servicos = [
            ['nome' => 'Corte Masculino', 'preco' => 35.00, 'empresa_id' => 1],
            ['nome' => 'Corte Feminino', 'preco' => 80.00, 'empresa_id' => 1],
            ['nome' => 'Barba Completa', 'preco' => 25.00, 'empresa_id' => 1],
            ['nome' => 'Manicure', 'preco' => 40.00, 'empresa_id' => 1],
            ['nome' => 'Pedicure', 'preco' => 40.00, 'empresa_id' => 1],
            ['nome' => 'Escova e Lavagem', 'preco' => 60.00, 'empresa_id' => 1],
            ['nome' => 'Tintura', 'preco' => 120.00, 'empresa_id' => 1],
            ['nome' => 'Design de Sobrancelha', 'preco' => 30.00, 'empresa_id' => 1],
        ];

        foreach ($servicos as $item) {
            Servico::create($item);
        }
    }
}