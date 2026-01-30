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
        return ['database', 'mail']; // Pode adicionar 'mail' se quiser enviar por e-mail também
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
    public function toMail($notifiable)
{
    \Log::debug('ENTROU NA FUNCAO EMAIL'); // Verifique o conteúdo no log

    $percentUsed = round($this->percentUsed); // Arredonda o valor de porcentagem para o número inteiro

    return (new MailMessage)
        ->subject('Aviso: Espaço em Disco Quase Cheio')
        ->greeting('Olá!')
        ->line("Seu armazenamento atingiu {$percentUsed}% da capacidade.")
        ->line('Considere liberar espaço para evitar problemas.')
        ->action('Verificar Espaço', url('/dashboard')) // Link para a página de detalhes
        ->line('Para mais informações sobre o uso do seu espaço, acesse a página de detalhes abaixo:')
        ->line('URL para a página de detalhes: ' . url('/dashboard')) // Adiciona a URL ao e-mail
        ->line('Se você está tendo problemas ao clicar no botão, copie e cole a URL acima no seu navegador.')
        ->salutation('Atenciosamente, Proconline')
        ->view('emails.send-email-alerts', ['percentUsed' => $percentUsed]); // Chamando uma view personalizada para o corpo do e-mail (caso queira usar HTML personalizado)
}

}
