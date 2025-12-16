<?php

namespace App\Discord\Events;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class MessageCreate
{
    public function __construct(Discord $discord, array $commands)
    {
        $discord->on('message', function (Message $message, Discord $discord) use ($commands) {
            // Ignore bot messages
            if ($message->author->bot) {
                return;
            }
            
            $prefix = config('discord.prefix');
            $content = $message->content;
            
            // Check if message starts with prefix
            if (strpos($content, $prefix) !== 0) {
                return;
            }
            
            // Parse command
            $args = explode(' ', substr($content, strlen($prefix)));
            $commandName = strtolower(array_shift($args));
            
            // Find and execute command
            if (isset($commands[$commandName])) {
                $command = $commands[$commandName];
                
                try {
                    $command->handle($message, $discord, $args);
                    
                    // Log command usage
                    echo "📝 Command executed: {$commandName} by {$message->author->username}\n";
                } catch (\Exception $e) {
                    $message->channel->sendMessage("❌ Error executing command: " . $e->getMessage());
                    echo "❌ Command error: {$e->getMessage()}\n";
                }
            }
        });
    }
}