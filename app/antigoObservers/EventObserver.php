<?php

namespace App\Observers;

use App\Events\EventUpdated;
use App\Events\NewEventCreated; // Adicionar a importação do evento
use App\Models\Event;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event)
    {
        // Disparar o evento de broadcast
        \Log::info('OBSERVER: '.$event->name);
        broadcast(new NewEventCreated($event));
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event)
    {
        // Log para confirmar que o evento foi atualizado
        \Log::info('OBSERVER atualizado: '.$event->name);

        // Disparar o evento de broadcast
        broadcast(new EventUpdated($event));
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
