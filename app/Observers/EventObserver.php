<?php

namespace App\Observers;

use App\Models\Event;
use App\Events\NewEventCreated; // Adicionar a importação do evento

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event)
    {
        // Disparar o evento de broadcast
        \Log::info("Novo evento criado: " . $event->name);
        broadcast(new NewEventCreated($event));
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        //
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
