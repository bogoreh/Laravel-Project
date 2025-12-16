<?php

namespace App\Discord\Services;

use Discord\Discord;
use Discord\WebSockets\Intents;
use Illuminate\Support\Facades\Log;

class DiscordService
{
    protected $discord;
    protected $commands = [];

    public function __construct()
    {
        $this->initializeBot();
    }

    private function initializeBot()
    {
        $this->discord = new Discord([
            'token' => config('discord.token'),
            'intents' => Intents::getDefaultIntents() | Intents::MESSAGE_CONTENT,
            'logger' => Log::channel('discord'),
        ]);

        $this->loadCommands();
        $this->registerEvents();
    }

    private function loadCommands()
    {
        $commandFiles = glob(app_path('Discord/Commands/*.php'));
        
        foreach ($commandFiles as $file) {
            $className = 'App\\Discord\\Commands\\' . basename($file, '.php');
            
            if (class_exists($className)) {
                $command = new $className();
                $this->commands[$command->name] = $command;
            }
        }
    }

    private function registerEvents()
    {
        $eventFiles = glob(app_path('Discord/Events/*.php'));
        
        foreach ($eventFiles as $file) {
            $className = 'App\\Discord\\Events\\' . basename($file, '.php');
            
            if (class_exists($className)) {
                new $className($this->discord, $this->commands);
            }
        }
    }

    public function run()
    {
        $this->discord->run();
    }

    public function getDiscord(): Discord
    {
        return $this->discord;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }
}