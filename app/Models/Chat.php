<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    // Remove os campos antigos
    protected $fillable = [];

    // Chat tem muitos usuários via tabela pivô
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }

    // Chat tem muitas mensagens
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
