<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutorgadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('outorgados')->insert([
            [
                'id'               => 1,
                'nome_outorgado'   => 'OUTORGADO 1',
                'cpf_outorgado'    => '111.111.111-11',
                'rg_outorgado'     => '9999999999',
                'telefone_outorgado'     => '51999999999',
                'end_outorgado'    => 'AV FARRAPOS, 123, BAIRRO GUAIBA, PORTO ALEGRE/RS',
                'email_outorgado'  => 'outorgado1@gmail.com',
                'user_id'          => 1,
                'empresa_id'       => 1,
                'created_at'       => '2026-01-30 09:53:04',
                'updated_at'       => '2026-01-30 09:53:04',
            ],
            [
                'id'               => 2,
                'nome_outorgado'   => 'OUTORGADO 1',
                'cpf_outorgado'    => '111.111.111-11',
                'rg_outorgado'     => '51999999999',
                'telefone_outorgado'     => '9999999999',
                'end_outorgado'    => 'AV FARRAPOS, 123, BAIRRO GUAIBA, PORTO ALEGRE/RS',
                'email_outorgado'  => 'outorgado1@gmail.com',
                'user_id'          => 2,
                'empresa_id'       => 2,
                'created_at'       => '2026-01-30 09:53:04',
                'updated_at'       => '2026-01-30 09:53:04',
            ],
            // Você pode adicionar mais outorgados aqui seguindo o mesmo padrão
        ]);
    }
}