<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WebScraperService;

class ScrapeCommand extends Command
{
    protected $signature = 'scrape:website {url} {--S|selectors=}';
    protected $description = 'Scrape a website from command line';

    protected $scraperService;

    public function __construct(WebScraperService $scraperService)
    {
        parent::__construct();
        $this->scraperService = $scraperService;
    }

    public function handle()
    {
        $url = $this->argument('url');
        $selectors = $this->option('selectors');

        $parsedSelectors = [];
        if ($selectors) {
            $selectorArray = explode(',', $selectors);
            foreach ($selectorArray as $index => $selector) {
                $parsedSelectors["selector_{$index}"] = trim($selector);
            }
        }

        $this->info("Scraping website: {$url}");
        $this->line("");

        $result = $this->scraperService->scrapeWebsite($url, $parsedSelectors);

        if ($result['success']) {
            $this->info("✓ Successfully scraped website");
            $this->line("");
            
            $this->info("Title: " . $result['data']['title']);
            $this->info("Description: " . ($result['data']['meta_description'] ?: 'N/A'));
            $this->info("Links found: " . count($result['data']['all_links']));
            $this->info("Images found: " . count($result['data']['images']));
            
            // Save to database
            $saved = $this->scraperService->saveScrapedData($url, $result);
            $this->info("✓ Data saved to database with ID: {$saved->id}");
        } else {
            $this->error("✗ Failed to scrape website");
            $this->error("Error: " . $result['error']);
        }

        return $result['success'] ? 0 : 1;
    }
}