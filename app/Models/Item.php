<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'itens';

    protected $fillable = [
        'referencia',
        'produto',
        'valor',
        'valor_venda',
        'multiplicador',
    ];

public function extrairReferencia($linha)
{
    if (preg_match('/^\d+/', $linha, $matches)) {
        return $matches[0];
    }
    return null;
}

public function extrairProduto($linha)
{
    return preg_replace('/^\d+\s*/', '', $linha);
}

public function extrairValor($linha)
{
    if (preg_match('/\d{1,3}(?:\.\d{3})*,\d{2}/', $linha, $matches)) {
        $valor = str_replace(['.', ','], ['', '.'], $matches[0]);
        return (float) $valor;
    }
    return null;
}




}
