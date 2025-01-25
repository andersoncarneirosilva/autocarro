<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

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
            'fone' => '(51)99669.8989)',
            'email' => 'mari@gmail.com',
            'cep' => '92.035-580',
            'endereco' => 'Rua Santa Tereza',
            'numero' => '214',
            'bairro' => 'Olaria',
            'cidade' => 'Canoas',
            'estado' => 'RS',
            'user_id' => '1',
        ]);
    }
}