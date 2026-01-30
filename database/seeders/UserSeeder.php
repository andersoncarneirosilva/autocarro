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
            'telefone'      => '(51)9.99137.7276',
            'nivel_acesso'  => 'Administrador',
            'password'      => Hash::make('12345678'),
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
            'telefone'       => '47988552396',
            'nivel_acesso'   => 'Administrador',
            'password'       => '$2y$10$kwDZt8yqARkx5MrNZGaT4u5Qtu5Dq8Fjgo3NKE5B4F/BAjnIdQw0G', // Senha original mantida
            'status'         => 'Ativo',
            'plano'          => 'Teste',
            'credito'        => 0.00,
            'empresa_id'     => 2,
            'last_login_at'  => '2026-01-01 00:00:25',
        ]);
}
}
