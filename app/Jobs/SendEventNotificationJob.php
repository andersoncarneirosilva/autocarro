<?php

namespace App\Jobs;

use App\Models\Event; // Certifique-se de que a classe Event está correta
use App\Models\User;
use App\Notifications\EventCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEventNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    /**
     * Cria uma nova instância do job.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Executa o job.
     */
    public function handle()
    {
        // Recupera todos os usuários para notificar
        $users = User::all();

        // Envia a notificação para cada usuário
        foreach ($users as $user) {
            $eventData = [
                'id' => $this->event->id,
                'title' => $this->event->title,
                'event_date' => $this->event->event_date,
                'created_at' => $this->event->created_at,
                'category' => $this->event->category,
            ];

            $user->notify(new EventCreatedNotification($eventData));
        }

        \Log::info('Notificação enviada para todos os usuários sobre o evento: '.$this->event->created_at);
    }
}
