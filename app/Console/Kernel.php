<?php

namespace App\Console;

use App\Console\Commands\DumpLocaleDatabaseCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule) : void
    {
        $schedule->command(DumpLocaleDatabaseCommand::class)->daily();
        $schedule->command(PruneCommand::class)->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands() : void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
