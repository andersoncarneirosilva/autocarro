<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        
        \Log::debug('ENVIADO PARA A TABLE: '.$this->event); // Verifique o conteúdo no log
        return [
            'message' => $this->event['title'],
            'event_id' => $this->event['id'],
            'event_date' => $this->event['event_date'],
            'created_at' => $this->event['created_at'],
        ];
    }

}
