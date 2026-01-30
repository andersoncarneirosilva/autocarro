<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class EventReminderBroadcast implements ShouldBroadcast
{
    use SerializesModels;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function broadcastOn()
    {
        return new Channel('events');
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->event->title,
            'event_date' => $this->event->event_date,
        ];
    }
}
