<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\CheckRefundStatus::class,
        \App\Console\Commands\CheckRefundStatusForReturn::class,
        \App\Console\Commands\UpdateSevenDaysStatus::class,
    ];
    
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:refundstatus')->everyFiveMinutes();
        $schedule->command('check:refundstatusforreturn')->everyFiveMinutes();
        $schedule->command('orders:update-seven-days-status')->daily();
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
