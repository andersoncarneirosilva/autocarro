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
    // Usuário Anderson
    User::create([
        'name' => 'Anderson',
        'email' => 'andersonqipoa@gmail.com',
        'telefone' => '(51)9.99137.7276',
        'nivel_acesso' => 'Administrador',
        'password' => bcrypt('12345678'),
        'status' => 'Ativo',
    ]);

    // Usuário Pedro
    User::create([
        'name' => 'Pedro',
        'email' => 'pedro@gmail.com',
        'telefone' => '(51)9.9999.9999',
        'nivel_acesso' => 'Usuário',
        'password' => bcrypt('12345678'),
        'status' => 'Ativo',
    ]);
}
}
