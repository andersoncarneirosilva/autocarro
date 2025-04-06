<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa (adicione conforme necessário)
    protected $fillable = [];

    // Relacionamento com usuários (tabela pivô com timestamps e campo extra)
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user')
                    ->withPivot('last_read_at')  // habilita o acesso ao campo
                    ->withTimestamps();          // habilita created_at e updated_at
    }

    // Relacionamento com mensagens
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
