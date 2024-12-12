<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Cliente;
use App\Models\Documento;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::create([
            'nome' => 'MARILENE PRATES CARNEIRO DA SILVA',
            'cpf' => 'IPJ-8525',
            'fone' => '2SA1DS1F4TR74YG4',
            'email' => 'VERDE',
            'cep' => '2022/2023',
            'endereco' => '102030404',
            'bairro' => 'FABIO DA SILVA',
            'cidade' => '023.546.070-09',
            'cidade' => 'ESTEIO/RS',
            'estado' => '32158740087',
            'arquivo_doc_veiculo' => 'IPJ-1245',
            'doc_id' => 'PARTICULAR',
            'motor' => '2r4f477t4f',
            'combustivel' => 'GASOLINA',
            'infos' => 'IPJ-8525',
            'arquivo_doc' => 'test.pdf',

        ]);
    }
}
