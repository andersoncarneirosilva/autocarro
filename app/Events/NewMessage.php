<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        Log::info('✅ Evento NewMessage CONSTRUTOR chamado!', ['message' => $message->content]);
    }

    public function broadcastOn()
    {
        Log::info('📡 Transmitindo no canal chat');
        return new Channel('chat'); // Garantir que o canal é público
    }

    public function broadcastAs()
    {
        Log::info('📢 Nome do evento: NewMessage');
        return 'NewMessage';
    }

    public function broadcastWith()
{
    Log::info('📤 Dados enviados no evento:', ['message' => $this->message]);

    return [
        'content' => 'Teste forçado',
        'sender_id' => 1,
        'created_at' => now()->toISOString(),
    ];
}

}
