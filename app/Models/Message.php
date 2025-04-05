<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'sender_id', 'chat_id'];

    /**
     * Remetente da mensagem (usuário que enviou)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Chat ao qual a mensagem pertence
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
