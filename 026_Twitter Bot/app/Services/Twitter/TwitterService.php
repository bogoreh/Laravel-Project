<?php

namespace App\Services\Twitter;

use App\Exceptions\TwitterException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwitterService
{
    protected array $config;
    protected string $baseUrl = 'https://api.twitter.com/2';

    public function __construct()
    {
        $this->config = config('twitter');
    }

    public function tweet(string $text): array
    {
        if (strlen($text) > $this->config['settings']['max_tweet_length']) {
            throw new TwitterException('Tweet exceeds maximum length');
        }

        $response = Http::withToken($this->config['bearer_token'])
            ->post("{$this->baseUrl}/tweets", [
                'text' => $text
            ]);

        if ($response->failed()) {
            Log::error('Twitter API Error', $response->json());
            throw new TwitterException('Failed to post tweet: ' . $response->body());
        }

        return $response->json();
    }

    public function reply(string $text, string $replyToTweetId): array
    {
        return $this->tweet($text);
    }

    public function getMentions(int $limit = 10): array
    {
        $userId = $this->getUserId();
        
        $response = Http::withToken($this->config['bearer_token'])
            ->get("{$this->baseUrl}/users/{$userId}/mentions", [
                'max_results' => $limit,
                'tweet.fields' => 'author_id,created_at,conversation_id'
            ]);

        if ($response->failed()) {
            throw new TwitterException('Failed to fetch mentions');
        }

        return $response->json('data', []);
    }

    protected function getUserId(): string
    {
        // Extract user ID from access token or make an API call
        // This is a simplified version
        $response = Http::withToken($this->config['bearer_token'])
            ->get("{$this->baseUrl}/users/me");

        return $response->json('data.id');
    }

    public function validateCredentials(): bool
    {
        try {
            $this->getUserId();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}