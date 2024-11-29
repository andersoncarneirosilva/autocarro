<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'telefone',
        'perfil',
        'cargo',
        'nascimento',
        'logradouro',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'senha',
        'confirmar_senha',
        'facebook',
        'instagram',
        'skype',
        'linkedin',
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
    ];
    
    //Pesquisar colaboradores
    public function getEmployees(string|null $search = null){

        $employee = $this->where(function ($query) use ($search) {
            if($search){
                $query->where('email', 'LIKE', "%{$search}%");
                $query->orWhere('name', 'LIKE', "%{$search}%");
            }
        })->paginate(10);
        return $employee;
    }

    public function getEmail(string|null $search = null){

        $email = $this->where(function ($query) use ($search) {
            if($search){
                $query->where('email', $search);
                $query->orWhere('name', 'LIKE', "%{$search}%");
            }
        });
        //dd($email);
        return $email;
    }

    public function validarForm($request){
        if (!$request->name) {
            return response()->json(['error' => 'Preencha o nome!']);
        }else if(!$request->email){
            return response()->json(['error' => 'Preencha o email!']);
        }
    }


}
