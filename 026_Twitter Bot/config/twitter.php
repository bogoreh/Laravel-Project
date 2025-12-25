<?php

return [
    'api_key' => env('TWITTER_API_KEY'),
    'api_secret' => env('TWITTER_API_SECRET'),
    'access_token' => env('TWITTER_ACCESS_TOKEN'),
    'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
    'bearer_token' => env('TWITTER_BEARER_TOKEN'),
    
    'settings' => [
        'tweet_interval' => env('TWEET_INTERVAL', 60), // minutes
        'monitor_mentions_interval' => env('MONITOR_MENTIONS_INTERVAL', 5), // minutes
        'max_tweet_length' => 280,
        'log_tweets' => true,
    ],
];