<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;
use Discord\Discord;

class PingCommand
{
    public $name = 'ping';
    public $description = 'Check bot latency';
    public $usage = '!ping';

    public function handle(Message $message, Discord $discord, array $args)
    {
        $start = microtime(true);
        
        $message->channel->sendMessage("🏓 Pong!")->then(function ($sentMessage) use ($start) {
            $latency = round((microtime(true) - $start) * 1000);
            $sentMessage->edit("🏓 Pong! `{$latency}ms`");
        });
    }
}