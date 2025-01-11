<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProcRapida;

class ProcRapidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProcRapida::create([
            'marca' => 'Honda CBR900',
            'placa' => 'IPJ-8525',
            'chassi' => '2SA1DS1F4TR74YG4',
            'cor' => 'VERDE',
            'ano' => '2022/2023',
            'renavam' => '102030404',
            'nome' => 'FABIO DA SILVA',
            'cpf' => '023.546.070-09',
            'endereco' => 'Rua Teste, 550',
            'cidade' => 'ESTEIO/RS',
            'crv' => '32158740087',
            'placaAnterior' => 'IPJ-1245',
            'categoria' => 'PARTICULAR',
            'motor' => '2r4f477t4f',
            'combustivel' => 'GASOLINA',
            'infos' => 'IPJ-8525',
            'arquivo_doc' => 'test.pdf',

        ]);
    }
}
