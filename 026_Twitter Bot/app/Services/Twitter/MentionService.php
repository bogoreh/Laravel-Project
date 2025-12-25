<?php

namespace App\Services\Twitter;

use App\Models\TweetLog;
use App\Services\Content\ContentGenerator;

class MentionService
{
    protected TwitterService $twitter;
    protected ContentGenerator $contentGenerator;
    protected array $repliedTo = [];

    public function __construct(TwitterService $twitter, ContentGenerator $contentGenerator)
    {
        $this->twitter = $twitter;
        $this->contentGenerator = $contentGenerator;
        $this->loadRepliedToCache();
    }

    public function monitorAndReply(): int
    {
        $mentions = $this->twitter->getMentions(20);
        $repliedCount = 0;

        foreach ($mentions as $mention) {
            if ($this->shouldReply($mention)) {
                $this->replyToMention($mention);
                $repliedCount++;
            }
        }

        return $repliedCount;
    }

    protected function shouldReply(array $mention): bool
    {
        // Check if we've already replied to this tweet
        if (in_array($mention['id'], $this->repliedTo)) {
            return false;
        }

        // Check if it's our own tweet
        if ($mention['author_id'] === $this->twitter->getUserId()) {
            return false;
        }

        // Add more business logic here as needed
        return true;
    }

    protected function replyToMention(array $mention): void
    {
        $replyText = $this->contentGenerator->generateReply($mention['text']);

        $log = TweetLog::create([
            'content' => $replyText,
            'type' => 'reply',
            'status' => 'pending',
        ]);

        try {
            $response = $this->twitter->reply($replyText, $mention['id']);
            
            $log->update([
                'tweet_id' => $response['data']['id'] ?? null,
                'response_data' => $response,
                'status' => 'posted',
            ]);

            $this->repliedTo[] = $mention['id'];
            $this->saveRepliedToCache();
        } catch (\Exception $e) {
            $log->update([
                'response_data' => ['error' => $e->getMessage()],
                'status' => 'failed',
            ]);
        }
    }

    protected function loadRepliedToCache(): void
    {
        $this->repliedTo = TweetLog::where('type', 'reply')
            ->where('status', 'posted')
            ->pluck('tweet_id')
            ->filter()
            ->toArray();
    }

    protected function saveRepliedToCache(): void
    {
        // For a simple implementation, we just keep it in memory
        // For production, consider using Redis or database caching
    }
}