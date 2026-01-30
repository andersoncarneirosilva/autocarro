<?php

// namespace App\Events;

// use App\Models\Message;
// use Illuminate\Broadcasting\Channel;
// use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// use Illuminate\Foundation\Events\Dispatchable;
// use Illuminate\Queue\SerializesModels;
// use Log;

// class NewMessage implements ShouldBroadcast
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public $message;

//     public function __construct(Message $message)
//     {
//         $this->message = $message;
//         Log::info('✅ Evento NewMessage CONSTRUTOR chamado!', ['message' => $message->content]);
//     }

//     public function broadcastOn()
//     {
//         Log::info('📡 Transmitindo no canal chat');
//         return new Channel('chat'); // Garantir que o canal é público
//     }

//     public function broadcastAs()
//     {
//         Log::info('📢 Nome do evento: NewMessage');
//         return 'NewMessage';
//     }

//     public function broadcastWith()
//     {
//         Log::info('📤 Dados enviados no evento:', ['message' => $this->message]);

//         return [
//             'id' => $this->message->id,
//             'content' => $this->message->content,
//             'sender_id' => $this->message->sender_id,
//             'created_at' => $this->message->created_at->toISOString(),
//         ];
//     }
// }
namespace App\Events;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Log;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $chatId;  // Adicionando a propriedade chatId

    public function __construct(Message $message, $chatId)
    {
        $this->message = $message;
        $this->chatId = $chatId;  // Inicializando a propriedade chatId
        Log::info('✅ Evento NewMessage CONSTRUTOR chamado!', ['message' => $message->content]);
    }

    public function broadcastOn()
{
    Log::info('📡 FUNCAO broadcastOn CHAMADA');
    return new Channel('my-channel');  // Canal privado
}


    public function broadcastAs()
    {
        Log::info('📢 Funcao: broadcastAs');
        return 'NewMessage';
    }

    public function broadcastWith()
    {
        Log::info('📤 FUNCAO broadcastWith CHAMADA:', ['message' => $this->message]);

        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'sender_id' => $this->message->sender_id,
            'created_at' => $this->message->created_at->toISOString(),
        ];
    }
}
