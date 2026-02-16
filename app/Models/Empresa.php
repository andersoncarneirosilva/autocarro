<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Empresa extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome_responsavel',
        'razao_social',
        'cnpj',
        'slug',
        'email_corporativo',
        'telefone_comercial',
        'whatsapp',
        'logo',
        'status',
        'configuracoes',
        
        // Novos campos de endereço adicionados abaixo:
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
    ];

    /**
     * Casts de tipos de dados.
     * Transforma o JSON do banco em um array PHP automaticamente.
     */
    protected $casts = [
        'status' => 'boolean',
        'configuracoes' => 'array',
    ];

    /**
     * Boot function para lógica automática.
     * Gera o slug a partir do nome_fantasia antes de salvar.
     */
    protected static function boot()
{
    parent::boot();

    static::creating(function ($empresa) {
        // Mudamos para razao_social, que é o campo que você está preenchido no Controller
        if (empty($empresa->slug) && !empty($empresa->razao_social)) {
            $empresa->slug = Str::slug($empresa->razao_social) . '-' . rand(100, 999);
        }
    });
}
// Arquivo: app/Models/Empresa.php

public function profissionais()
{
    // Verifique se o nome da tabela no banco é 'profissionais'
    return $this->hasMany(Profissional::class, 'empresa_id', 'id');
}
    /**
     * Relacionamento: Uma empresa possui muitos usuários.
     * (Admins, funcionários ou clientes vinculados diretamente).
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'empresa_id');
    }

    /**
     * Escopo para buscar apenas empresas ativas.
     * Uso: Empresa::ativa()->get();
     */
    public function scopeAtiva($query)
    {
        return $query->where('status', true);
    }

    // No arquivo app/Models/Empresa.php

public function getUrlVitrineAttribute()
{
    return route('vitrine.salao', $this->slug);
}

// No Model Empresa.php

/**
 * Sobrescreve o método para usar o SLUG como chave de rota padrão
 */
public function getRouteKeyName()
{
    return 'slug';
}

/**
 * Acessador para garantir que sempre haja um valor para a rota
 */
public function getSlugAttribute($value)
{
    // Se por algum motivo o slug estiver vazio, retorna o ID para não quebrar a rota
    return $value ?? $this->id;
}

public function servicos()
{
    return $this->hasMany(Servico::class);
}

public function galeria()
{
    return $this->hasMany(Galeria::class)->orderBy('ordem', 'asc');
}
public function fotos()
{
    // Define que a empresa tem muitas fotos na tabela galerias
    return $this->hasMany(Galeria::class, 'empresa_id')->orderBy('ordem', 'asc');
}
}