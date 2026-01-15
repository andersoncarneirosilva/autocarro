<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Anderson',
            'email' => 'andersonqipoa@gmail.com',
            'telefone' => '(51)9.99137.7276',
            'nivel_acesso' => 'Administrador',
            'perfil' => 'Despachante',
            'plano' => 'Mensal',
            'password' => bcrypt('12345678'),
            'status' => 'Ativo',
            'credito' => '10',
        ]);
    }
}
