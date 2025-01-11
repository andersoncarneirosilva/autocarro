<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'perfil' => 'Lojista',
            'plano' => 'Mensal',
            'password' => bcrypt('12345678'),
            'classe' => 'badge badge-outline-success',
            'status' => 'Ativo',
            'credito' => '10',
        ]);
    }
}
