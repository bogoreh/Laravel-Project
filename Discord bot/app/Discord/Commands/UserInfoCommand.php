<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;
use Discord\Discord;

class UserInfoCommand
{
    public $name = 'userinfo';
    public $description = 'Get user information';
    public $usage = '!userinfo [@user]';

    public function handle(Message $message, Discord $discord, array $args)
    {
        $user = $message->mentions->first() ?? $message->author;
        
        $embed = [
            'title' => '👤 User Information',
            'color' => 0x2ecc71,
            'thumbnail' => [
                'url' => $user->avatar
            ],
            'fields' => [
                [
                    'name' => 'Username',
                    'value' => $user->username,
                    'inline' => true
                ],
                [
                    'name' => 'Discriminator',
                    'value' => $user->discriminator,
                    'inline' => true
                ],
                [
                    'name' => 'User ID',
                    'value' => $user->id,
                    'inline' => false
                ],
                [
                    'name' => 'Account Created',
                    'value' => $user->created_at->format('Y-m-d H:i:s'),
                    'inline' => false
                ]
            ],
            'footer' => [
                'text' => 'Requested by ' . $message->author->username
            ],
            'timestamp' => date('c')
        ];
        
        $message->channel->sendMessage('', false, $embed);
    }
}