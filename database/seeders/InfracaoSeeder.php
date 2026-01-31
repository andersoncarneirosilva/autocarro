<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $infracoes = [
        [
            'codigo' => '745-5',
            'descricao' => 'Transitar em velocidade superior à máxima permitida em até 20%',
            'gravidade' => 'Média',
            'pontos' => 4,
            'valor' => 130.16
        ],
        [
            'codigo' => '605-1',
            'descricao' => 'Avançar o sinal vermelho do semáforo ou o de parada obrigatória',
            'gravidade' => 'Gravíssima',
            'pontos' => 7,
            'valor' => 293.47
        ],
        [
            'codigo' => '501-0',
            'descricao' => 'Dirigir veículo sem possuir CNH ou Permissão para Dirigir',
            'gravidade' => 'Gravíssima',
            'pontos' => 7,
            'valor' => 880.41
        ],
        [
            'codigo' => '763-2',
            'descricao' => 'Dirigir veículo segurando ou manuseando telefone celular',
            'gravidade' => 'Gravíssima',
            'pontos' => 7,
            'valor' => 293.47
        ]
    ];

    foreach ($infracoes as $infracao) {
        \App\Models\Infracao::updateOrCreate(['codigo' => $infracao['codigo']], $infracao);
    }
}
}
