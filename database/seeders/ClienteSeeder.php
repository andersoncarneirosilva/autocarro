<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::create([
            'nome' => 'MARILENE PRATES CARNEIRO DA SILVA',
            'cpf' => '455.969.210-68',
            'rg' => '9999999999',
            'fone' => '(51)99669.8989',
            'email' => 'mari@gmail.com',
            'cep' => '92.035-580',
            'endereco' => 'Rua Santa Tereza',
            'numero' => '214',
            'bairro' => 'Olaria',
            'cidade' => 'Canoas',
            'estado' => 'RS',
            'user_id' => '1',
            'empresa_id' => '1',
        ]);
    }
}
