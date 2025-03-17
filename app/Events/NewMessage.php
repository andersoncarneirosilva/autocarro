<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;
class NewMessage implements ShouldBroadcast
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        Log::info('Evento NewMessage disparado!', ['message' => $message->content]);
    }

    public function broadcastOn()
    {
        Log::info('Transmitindo conteúdo da mensagem broadcastOn', ['message' => $this->message->content]);
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        Log::info('broadcastAs:: ');
        return 'NewMessage'; // Nome correto do evento
    }

    public function broadcastWith()
{
    Log::info('Transmitindo conteúdo da mensagem broadcastWith', ['message' => $this->message]);

    return [
        'id' => $this->message->id,
        'content' => $this->message->content,
        'sender_id' => $this->message->sender_id,
        'created_at' => $this->message->created_at->toDateTimeString(),
    ];
}


}