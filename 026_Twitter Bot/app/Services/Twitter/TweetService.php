<?php

namespace App\Services\Twitter;

use App\Models\TweetLog;
use App\Services\Content\ContentGenerator;

class TweetService
{
    protected TwitterService $twitter;
    protected ContentGenerator $contentGenerator;

    public function __construct(TwitterService $twitter, ContentGenerator $contentGenerator)
    {
        $this->twitter = $twitter;
        $this->contentGenerator = $contentGenerator;
    }

    public function postRandomTweet(): array
    {
        $content = $this->contentGenerator->generateTweet();
        
        return $this->postTweet($content);
    }

    public function postTweet(string $content): array
    {
        // Log the tweet attempt
        $log = TweetLog::create([
            'content' => $content,
            'type' => 'tweet',
            'status' => 'pending',
        ]);

        try {
            $response = $this->twitter->tweet($content);
            
            $log->update([
                'tweet_id' => $response['data']['id'] ?? null,
                'response_data' => $response,
                'status' => 'posted',
            ]);

            return $response;
        } catch (\Exception $e) {
            $log->update([
                'response_data' => ['error' => $e->getMessage()],
                'status' => 'failed',
            ]);
            
            throw $e;
        }
    }
}