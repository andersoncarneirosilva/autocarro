<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Empresa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Criar a Empresa (O container principal)
        $empresa = Empresa::updateOrCreate(
            ['email_corporativo' => 'contato@alcecar.com.br'], // Identificador único
            [
                'nome_responsavel'   => 'Anderson Admin',
                'razao_social'       => 'Alcecar Barbearia e Estética LTDA',
                'cnpj'               => '00.000.000/0001-00',
                'slug'               => 'alcecar-matriz',
                'telefone_comercial' => '(51) 3333-3333',
                'whatsapp'           => '(51) 99913-7276',
                'endereco'           => 'Av. Principal, 1000 - Centro',
                'logo'               => 'logos/default-logo.png',
                'status'             => true,
                'configuracoes'      => [
                    'cor_primaria' => '#727cf5',
                    'tema'         => 'light',
                    'abertura'     => '08:00',
                    'fechamento'   => '19:00'
                ],
            ]
        );

        // 2. Criar o Usuário Anderson vinculado à Empresa criada acima
        User::updateOrCreate(
            ['email' => 'andersonqipoa@gmail.com'],
            [
                'name'          => 'Anderson',
                'cpf'           => '013.887.090-07',
                'rg'            => '1080692153',
                'telefone'      => '(51)9.99137.7276',
                'nivel_acesso'  => 'Administrador',
                'password'      => Hash::make('12345678'),
                'status'        => 'Ativo',
                'plano'         => 'Pro',
                'credito'       => 0.00,
                'empresa_id'    => $empresa->id, // Chave estrangeira dinâmica
            ]
        );
    }
}