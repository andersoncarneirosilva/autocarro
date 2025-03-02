<?php

namespace App\Console\Commands;

use App\Events\EventReminderBroadcast;
use App\Models\Event; // Seu modelo de eventos
use Carbon\Carbon; // O evento de broadcast que será emitido
use Illuminate\Console\Command;

class NotificaEvents extends Command
{
    // Nome e descrição do comando
    protected $signature = 'events:notify-upcoming';

    protected $description = 'Notifica usuários sobre eventos que ocorrerão em uma hora';

    public function handle()
    {
        // Obtém a hora atual
        $now = Carbon::now();

        // Calcula o intervalo de uma hora no futuro
        $oneHourFromNow = $now->copy()->addHour();

        // Busca eventos que acontecerão dentro de uma hora
        $events = Event::whereBetween('event_date', [$now, $oneHourFromNow])->get();

        if ($events->isEmpty()) {
            $this->info('Nenhum evento para notificar.');

            return;
        }

        foreach ($events as $event) {
            // Emite o evento de broadcast
            event(new EventReminderBroadcast($event));
            $this->info("Notificação emitida para o evento: {$event->title} às {$event->event_date}");
        }
    }
}
