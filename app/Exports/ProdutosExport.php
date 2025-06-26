<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdutosExport implements FromCollection, WithHeadings
{
    protected $produtos;

    public function __construct(Collection $produtos)
    {
        $this->produtos = $produtos;
    }

    public function collection()
    {
        return $this->produtos->map(function ($item) {
            return [
                'referencia' => $item->referencia,
                'produto' => $item->produto,
                'valor' => number_format($item->valor, 2, ',', '.'),
                'multiplicador' => number_format($item->multiplicador, 2, ',', '.'),
                'valor_venda' => number_format($item->valor_venda, 2, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Referência',
            'Produto',
            'Valor',
            'Multiplicador',
            'Valor de Venda',
        ];
    }
}
