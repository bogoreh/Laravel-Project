<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Discord\Services\DiscordService;

class DiscordBotCommand extends Command
{
    protected $signature = 'discord:run';
    protected $description = 'Run the Discord bot';

    public function handle(DiscordService $discordService)
    {
        $this->info('Starting Discord bot...');
        $this->info('Press Ctrl+C to stop.');
        
        $discordService->run();
    }
}