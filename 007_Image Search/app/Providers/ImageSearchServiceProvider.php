<?php

namespace ImageSearch\Providers;

use Illuminate\Support\ServiceProvider;
use ImageSearch\Repositories\ImageSearchRepository;
use ImageSearch\Repositories\Interfaces\ImageSearchRepositoryInterface;

class ImageSearchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/image-search.php', 'image-search');
        $this->app->bind(ImageSearchRepositoryInterface::class, ImageSearchRepository::class);
    }

    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../../config/image-search.php' => config_path('image-search.php'),], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
    }
}
