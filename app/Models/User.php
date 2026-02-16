<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\MultiTenantModelTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, MultiTenantModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function routeNotificationForMail($notification)
{
    return $this->email;  // O endereço de e-mail do usuário
}


    protected $fillable = [
        'name',
        'email',
        'cpf',
        'telefone',
        'nivel_acesso',
        'password',
        'image',
        'status',
        'plano',
        'payment_status',
        'credito',
        'last_login_at',
        'empresa_id',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];

// No arquivo App\Models\User.php

public function empresa()
{
    /**
     * belongsTo(Classe, chave_estrangeira_nesta_tabela, chave_primaria_na_outra_tabela)
     * Como empresa_id está na tabela 'users', usamos belongsTo.
     */
    return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
}

    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class, 'user_id');
    }


    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    // Verifica se é o dono do salão
public function isSalao()
{
    return $this->nivel_acesso === 'salao';
}

// Verifica se é um cliente final
public function isCliente()
{
    return $this->nivel_acesso === 'cliente';
}

}
