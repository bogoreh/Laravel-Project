<?php

namespace App\Discord\Events;

use Discord\Discord;
use Discord\Parts\User\Activity;

class Ready
{
    public function __construct(Discord $discord, array $commands)
    {
        $discord->on('ready', function (Discord $discord) use ($commands) {
            echo "✅ Bot is ready! Logged in as {$discord->user->username}\n";
            echo "✅ Loaded " . count($commands) . " commands\n";
            
            // Set bot status
            $activity = $discord->factory(Activity::class, [
                'name' => config('discord.prefix') . 'help',
                'type' => Activity::TYPE_LISTENING,
            ]);
            
            $discord->updatePresence($activity);
        });
    }
}