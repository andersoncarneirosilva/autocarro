<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fornecedor::create([
            'razao_social' => 'Stella Importação',
            'nome_fantasia' => 'Stella Iluminação',
            'cnpj' => '12.012.123-0001/10',
            'representante' => 'Tiago',
            'telefone' => '(51)3131.1212',
            'ipi' => '12',
            'icms' => '17',
            'margem' => '35',
            'marcador' => '2.2020',
            'valor_pedido_minimo' => '350',
            'prazo_faturamento' => '10',
            'tipo_frete' => 'CIF',
            'transportadora' => 'Rodonaves',
        ]);
    }
}
