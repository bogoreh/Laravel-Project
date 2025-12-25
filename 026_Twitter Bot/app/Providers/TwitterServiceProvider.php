<?php

namespace App\Providers;

use App\Services\Content\ContentGenerator;
use App\Services\Twitter\MentionService;
use App\Services\Twitter\TweetService;
use App\Services\Twitter\TwitterService;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TwitterService::class, function () {
            return new TwitterService();
        });

        $this->app->singleton(ContentGenerator::class, function () {
            return new ContentGenerator();
        });

        $this->app->singleton(TweetService::class, function ($app) {
            return new TweetService(
                $app->make(TwitterService::class),
                $app->make(ContentGenerator::class)
            );
        });

        $this->app->singleton(MentionService::class, function ($app) {
            return new MentionService(
                $app->make(TwitterService::class),
                $app->make(ContentGenerator::class)
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/twitter.php' => config_path('twitter.php'),
        ], 'twitter-config');
    }
}