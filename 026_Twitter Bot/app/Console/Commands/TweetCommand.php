<?php

namespace App\Console\Commands;

use App\Services\Twitter\TweetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TweetCommand extends Command
{
    protected $signature = 'twitter:tweet 
                            {--random : Post a random tweet}
                            {--message= : Post a specific message}';
    
    protected $description = 'Post a tweet to Twitter';

    public function handle(TweetService $tweetService): int
    {
        try {
            if ($this->option('random')) {
                $response = $tweetService->postRandomTweet();
                $this->info('Random tweet posted successfully!');
            } elseif ($message = $this->option('message')) {
                $response = $tweetService->postTweet($message);
                $this->info('Tweet posted successfully!');
            } else {
                $this->error('Please specify either --random or --message');
                return Command::FAILURE;
            }

            $this->line("Tweet ID: " . ($response['data']['id'] ?? 'N/A'));
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to post tweet: ' . $e->getMessage());
            Log::error('Tweet failed', ['error' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }
}