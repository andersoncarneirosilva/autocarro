<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'cidade',
        'estado',
        'nivel_acesso',
        'password',
        'image',
        'status',
        'last_login_at',
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

    public function scopeVendedores($query)
{
    return $query->where('nivel_acesso', 'Vendedor');
}


    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class, 'user_id');
    }

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function getUsers(?string $search = null)
    {

        $users = $this->where(function ($query) use ($search) {
            if ($search) {
                $query->where('email', 'LIKE', "%{$search}%");
                $query->orWhere('name', 'LIKE', "%{$search}%");
            }
        })->paginate(10);

        // dd($users);
        return $users;
    }

    public function getEmail(?string $search = null)
    {

        $email = $this->where(function ($query) use ($search) {
            if ($search) {
                $query->where('email', $search);
                $query->orWhere('name', 'LIKE', "%{$search}%");
            }
        });

        // dd($email);
        return $email;
    }
}
