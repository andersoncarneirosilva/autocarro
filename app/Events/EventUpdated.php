<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $event;

    /**
     * Cria uma nova instância de evento.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * O canal para onde o evento será transmitido.
     */
    public function broadcastOn()
    {
        return new Channel('events');
    }

    /**
     * Nome do evento que será enviado no frontend.
     */
    public function broadcastAs()
    {
        return 'event.updated';
    }
}
