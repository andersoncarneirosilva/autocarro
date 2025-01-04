<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EventCreatedNotification extends Notification
{
    use Queueable;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        // Defina os canais pelos quais a notificação será enviada (aqui estamos usando 'database' para armazenar a notificação no banco de dados)
        return ['database']; // Aqui você pode adicionar outros canais como 'mail' ou 'sms' se necessário
    }

    public function toDatabase($notifiable)
    {
        \Log::debug($this->event); // Verifique o conteúdo no log
        return [
            'message' => 'Novo evento criado: ' . $this->event['title'], // Substitua 'name' por 'title'
            'event_id' => $this->event['id'],
            'event_date' => $this->event['event_date'],
        ];
    }

    // Se desejar enviar a notificação por email, use este método:
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('Novo evento criado: ' . $this->event['name'])
    //                 ->action('Ver Evento', url('/events/'.$this->event['id']));
    // }
}
