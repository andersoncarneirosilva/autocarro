<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StorageWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $percentUsed;

    /**
     * Criar uma nova instância da notificação.
     */
    public function __construct($percentUsed)
    {
        $this->percentUsed = $percentUsed;
    }

    /**
     * Canais de notificação.
     */
    public function via($notifiable)
    {
        return ['database']; // Pode adicionar 'mail' se quiser enviar por e-mail também
    }

    /**
     * Notificação para banco de dados.
     */
    public function toDatabase($notifiable)
{
    $percentUsed = round($this->percentUsed); // Arredonda para o número inteiro mais próximo

    return [
        'title' => "Alerta",
        'message' => "Você utilizou {$percentUsed}% da capacidade.",
        'percent_used' => $percentUsed,
        'class' => "warning",
        'created_at' => now(),
    ];
}


    /**
     * Notificação por e-mail (opcional).
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->subject('Aviso: Espaço em Disco Quase Cheio')
    //         ->line("Seu armazenamento atingiu {$this->percentUsed}% da capacidade.")
    //         ->action('Verificar Espaço', url('/dashboard'))
    //         ->line('Considere liberar espaço para evitar problemas.');
    // }
}
