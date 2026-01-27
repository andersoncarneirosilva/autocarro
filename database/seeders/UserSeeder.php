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
        'CPF' => '013.887.090-07',
        'telefone' => '(51)9.99137.7276',
        'nivel_acesso' => 'Administrador',
        'password' => bcrypt('12345678'),
        'status' => 'Ativo',
    ]);

    // Usuário Pedro
    // User::create([
    //     'name' => 'Pedro',
    //     'email' => 'alcemar@gmail.com',
    //     'CPF' => '000.000.000-00',
    //     'telefone' => '(51)9.9999.9999',
    //     'nivel_acesso' => 'Revenda',
    //     'password' => bcrypt('12345678'),
    //     'status' => 'Ativo',
    // ]);
}
}
