<?php

return [
    'default' => [
        'host' => env('FTP_HOST', 'localhost'),
        'username' => env('FTP_USERNAME', ''),
        'password' => env('FTP_PASSWORD', ''),
        'port' => env('FTP_PORT', 21),
        'ssl' => env('FTP_SSL', false),
        'timeout' => env('FTP_TIMEOUT', 30),
    ],
];