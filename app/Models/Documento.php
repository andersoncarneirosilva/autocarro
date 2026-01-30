<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'veiculo_id', 'cliente_id',
        'arquivo_proc', 'size_proc', 'arquivo_proc_assinado',
        'arquivo_atpve', 'size_atpve', 'arquivo_atpve_assinado',
        'arquivo_comunicacao', 'size_comunicacao', 'arquivo_comunicacao_assinado',
        'size_proc_pdf', 'size_atpve_pdf', 'size_comunicacao_pdf' ,'empresa_id'
    ];

    public function anuncio()
{
    return $this->belongsTo(Veiculo::class, 'veiculo_id');
}

    // Relacionamentos
    public function usuario() { return $this->belongsTo(User::class, 'user_id'); }
    public function veiculo() { return $this->belongsTo(Veiculo::class); }
    public function cliente() { return $this->belongsTo(Cliente::class); }
    
}