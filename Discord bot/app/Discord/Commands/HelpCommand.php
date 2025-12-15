<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;
use Discord\Discord;
use App\Discord\Services\DiscordService;

class HelpCommand
{
    public $name = 'help';
    public $description = 'Show available commands';
    public $usage = '!help';

    public function handle(Message $message, Discord $discord, array $args, DiscordService $discordService)
    {
        $commands = $discordService->getCommands();
        $prefix = config('discord.prefix');
        
        $embed = [
            'title' => '🤖 Available Commands',
            'color' => 0x3498db,
            'fields' => [],
            'footer' => [
                'text' => 'Type ' . $prefix . 'command for more info'
            ]
        ];
        
        foreach ($commands as $command) {
            $embed['fields'][] = [
                'name' => $prefix . $command->name,
                'value' => $command->description,
                'inline' => true
            ];
        }
        
        $message->channel->sendMessage('', false, $embed);
    }
}