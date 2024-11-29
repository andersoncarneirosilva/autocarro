<?php

namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\VerificarParcelaVencida::class,
    ];    

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        //$schedule->command('VerificarParcelaVencida:verificar')->hourly();
        //$schedule->command('VerificarParcelaVencida:verificar')->dailyAt('14:48');
        $schedule->command('VerificarParcelaVencida:verificar')->everyMinute();
        
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
