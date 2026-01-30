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
    // Usuário 1: Anderson
        User::create([
            'name'          => 'Anderson',
            'email'         => 'andersonqipoa@gmail.com',
            'cpf'           => '013.887.090-07',
            'rg'           => '1080692153',
            'telefone'      => '(51)9.99137.7276',
            'nivel_acesso'  => 'Administrador',
            'password' => bcrypt('12345678'),
            'status'        => 'Ativo',
            'plano'         => 'Pro',
            'credito'       => 0.00,
            'empresa_id'    => 1, // Ajuste conforme sua tabela de empresas
        ]);

        // Usuário 2: AutoVip
        User::create([
            'id'             => 2,
            'name'           => 'AutoVip',
            'email'          => 'lojautovip@gmail.com',
            'cpf'            => '04311267609',
            'rg'            => '9999999999',
            'telefone'       => '47988552396',
            'nivel_acesso'   => 'Administrador',
            'password' => bcrypt('12345678'),
            'status'         => 'Ativo',
            'plano'          => 'Teste',
            'credito'        => 0.00,
            'empresa_id'     => 2,
            'last_login_at'  => '2026-01-01 01:01:01',
        ]);

        User::create([
            'id'             => 3,
            'name'           => 'Usuario',
            'email'          => 'usuario@gmail.com',
            'cpf'            => '99999999990',
            'rg'            => '9999999997',
            'telefone'       => '51999999999',
            'nivel_acesso'   => 'Administrador',
            'password' => bcrypt('12345678'),
            'status'         => 'Ativo',
            'plano'          => 'Teste',
            'credito'        => 0.00,
            'empresa_id'     => 3,
            'last_login_at'  => '2026-01-01 01:01:01',
        ]);


}
}
