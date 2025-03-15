<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Pusher\PusherException;

use Log;

class NewMessage implements ShouldBroadcastNow

{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        Log::info('Evento NewMessage disparado!', ['message' => $message->content]);
    }

    public function broadcastOn()
    {
        $socketId = request()->header('X-Socket-ID');
        
        Log::info('Verificando Socket ID recebido:', ['socket_id' => $socketId]);
    
        if (!$socketId || $socketId === 'undefined') {
            Log::error('Socket ID não foi recebido corretamente');
            throw new PusherException('Socket ID não recebido corretamente');
        }
    
        Log::info('Transmitindo para o canal: chat', ['message' => $this->message->content]);
    
        return new Channel('chat');  // Nome do canal no frontend
    }
    
    
    

    public function broadcastWith()
    {
        Log::info('Transmitindo conteúdo da mensagem para o canal: chat', ['message' => $this->message->content]);
        // return ['message' => $this->message->content];  // Envia o conteúdo da mensagem

        return [
            'message' => $this->message->content,
            'sender_id' => $this->message->sender_id,
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }
}
