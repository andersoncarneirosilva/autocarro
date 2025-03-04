<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\StorageWarningNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationStorageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $percentUsed;

    /**
     * Criar uma nova instância do Job.
     */
    public function __construct(User $user, $percentUsed)
    {
        $this->user = $user;
        $this->percentUsed = $percentUsed;
    }

    /**
     * Executar o Job.
     */
    public function handle()
    {
        if ($this->percentUsed >= 80) {
            $this->user->notify(new StorageWarningNotification($this->percentUsed));
            Log::info("Notificação de armazenamento enviada para o usuário ID: {$this->user->id} ({$this->percentUsed}% usado).");
        }
    }
}
