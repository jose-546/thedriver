<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\UpdateReservationStatus;

class Kernel extends ConsoleKernel
{

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule)
{
    $schedule->command('cars:update-status')->daily();
    
    $schedule->command('reservations:check')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->onOneServer()
                 ->appendOutputTo(storage_path('logs/reservations-check.log'));

        // Nettoyage des logs de réservations (optionnel)
    $schedule->exec('truncate -s 0 ' . storage_path('logs/reservations-check.log'))
                 ->weekly();


        // Vérifier les réservations expirées toutes les minutes
    $schedule->command('reservations:check-expired')
             ->everyMinute()
             ->withoutOverlapping()
             ->runInBackground();
}

}
