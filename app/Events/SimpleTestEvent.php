<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class SimpleTestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct()
    {
        $this->message = "Hello from Laravel!";
        Log::info("SimpleTestEvent triggered!");
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }
}
