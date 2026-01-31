<?php

namespace App\Imports;

use App\Models\Infracao;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class InfracoesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $cont = 0;
        foreach ($rows as $index => $row) {
            // Pula cabeçalho
            if ($index === 0) continue;

            $codigoBase = trim($row[0] ?? '');
            if (empty($codigoBase) || $codigoBase == 'Código da Infração') continue;

            $desdob = trim($row[1] ?? '');
            $codigoCompleto = $desdob !== '' ? $codigoBase . '-' . $desdob : $codigoBase;

            $gravidadeTexto = (string)($row[5] ?? '');

            Infracao::updateOrCreate(
                ['codigo' => $codigoCompleto],
                [
                    'descricao' => $row[2] ?? 'Sem descrição',
                    'gravidade' => $gravidadeTexto,
                    'pontos'    => $this->converterPontos($gravidadeTexto),
                    'valor'     => $this->definirValor($gravidadeTexto),
                ]
            );
            $cont++;
        }
        
        // Isso vai aparecer no seu terminal
        dump("Processadas {$cont} linhas nesta aba.");
    }

    private function converterPontos($g) {
    $g = mb_strtolower((string)$g);
    
    // Regra do CTB: Infrações que suspendem direto (como recusa de bafômetro)
    // muitas vezes não somam pontos na CNH, mas o sistema pode registrar 7.
    if (str_contains($g, 'gravíss')) return 7;
    if (str_contains($g, 'grave'))   return 5;
    if (str_contains($g, 'média'))   return 4;
    if (str_contains($g, 'leve'))    return 3;
    return 0;
}

private function definirValor($g) {
    $g = mb_strtolower((string)$g);
    $valorBase = 0;

    if (str_contains($g, 'gravíss')) $valorBase = 293.47;
    elseif (str_contains($g, 'grave'))   $valorBase = 195.23;
    elseif (str_contains($g, 'média'))   $valorBase = 130.16;
    elseif (str_contains($g, 'leve'))    $valorBase = 88.38;

    // Lógica para Multiplicadores (Ex: Gravíss 10X)
    // Procura por um número seguido de 'x' no texto
    if (preg_match('/(\d+)x/', $g, $matches)) {
        $multiplicador = (int) $matches[1];
        return $valorBase * $multiplicador;
    }

    return $valorBase;
}
}