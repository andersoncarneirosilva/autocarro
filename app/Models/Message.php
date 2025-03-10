<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\ShouldBroadcast;

class Message extends Model
{
    use HasFactory;

    // Inclua 'sender_id' no array $fillable
    protected $fillable = ['content', 'sender_id'];

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
