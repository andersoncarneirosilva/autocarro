<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Event;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Notifica via e-mail e salva no banco
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Lembrete: Evento Próximo')
                    ->line("Seu evento '{$this->event->title}' começará em menos de uma hora.")
                    ->line('Horário: ' . $this->event->event_date)
                    ->action('Ver Evento', url('/events/' . $this->event->id))
                    ->line('Não perca!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->event->title,
            'date' => $this->event->event_date,
        ];
    }
}

