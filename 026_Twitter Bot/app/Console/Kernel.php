<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\TweetCommand::class,
        Commands\MonitorMentionsCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Post a random tweet every hour
        $schedule->command('twitter:tweet --random')
            ->hourly()
            ->withoutOverlapping()
            ->onOneServer();

        // Monitor mentions every 5 minutes
        $schedule->command('twitter:monitor-mentions')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->onOneServer();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}