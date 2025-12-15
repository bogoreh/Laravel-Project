<?php

return [
    'token' => env('DISCORD_TOKEN'),
    'prefix' => env('DISCORD_PREFIX', '!'),
    
    'options' => [
        'disable_notices' => true,
    ],
    
    'commands' => [
        'path' => app_path('Discord/Commands'),
        'prefix' => env('DISCORD_PREFIX', '!'),
    ],
    
    'events' => [
        'path' => app_path('Discord/Events'),
    ],
];