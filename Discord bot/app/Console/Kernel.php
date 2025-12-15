<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\DiscordBotCommand::class,
        \App\Console\Commands\DiscordSetupCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule tasks if needed
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}