<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Source;
use App\Services\RssFetcher;

class FetchArticles extends Command
{
    protected $signature = 'articles:fetch';
    protected $description = 'Fetch articles from all active sources';

    public function handle()
    {
        $sources = Source::where('is_active', true)->get();
        $fetcher = new RssFetcher();

        foreach ($sources as $source) {
            $this->info("Fetching from: {$source->name}");
            
            try {
                $fetcher->fetch($source);
                $this->info("Successfully fetched from {$source->name}");
            } catch (\Exception $e) {
                $this->error("Error fetching from {$source->name}: " . $e->getMessage());
            }
        }

        $this->info('All articles fetched successfully!');
    }
}