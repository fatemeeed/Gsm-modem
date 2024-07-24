<?php

namespace App\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        
        // $schedule->command('auto:recieveMessage')->everyThirtyMinutes();
        $schedule->command('auto:orderHourly')->hourly();
        $schedule->command('auto:orderEveryThirty')->everyThirtyMinutes();
        $schedule->command('auto:orderEveryFifteen')->everyFifteenMinutes();
        $schedule->command('auto:orderEveryTen')->everyTenMinutes();
        $schedule->command('auto:recieveMessage')->everyThirtyMinutes()->withoutOverlapping();
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
