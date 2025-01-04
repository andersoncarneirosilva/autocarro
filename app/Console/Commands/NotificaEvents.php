<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event; // Seu modelo de eventos
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventReminderNotification;
use Carbon\Carbon;

class NotificaEvents extends Command
{
    // Nome e descrição do comando
    protected $signature = 'events:notify-upcoming';
    protected $description = 'Notifica usuários sobre eventos que ocorrerão em uma hora';

    public function handle()
    {
        // Obtém a hora atual
        $now = Carbon::now();
        $oneHourLater = $now->copy()->addHour();

        // Busca eventos com horário entre agora e uma hora no futuro
        $events = Event::whereBetween('event_date', [$now, $oneHourLater])->get();

        foreach ($events as $event) {
            // Notifica o usuário associado ao evento (ajuste conforme seu modelo)
            if ($event->user) {
                Notification::send($event->user, new EventReminderNotification($event));
            }
        }

        $this->info('Notificações enviadas para eventos futuros.');
    }
}
