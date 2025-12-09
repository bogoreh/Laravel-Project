<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\ScrapedData;
use Exception;

class WebScraperService
{
    protected $client;
    protected $timeout = 30;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => $this->timeout,
            'verify' => false, // For development only, remove in production
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
            ]
        ]);
    }

    public function scrapeWebsite($url, $selectors = [])
    {
        try {
            // Fetch the HTML content
            $response = $this->client->get($url);
            $html = $response->getBody()->getContents();

            $crawler = new Crawler($html);
            
            $data = [
                'url' => $url,
                'title' => $this->extractTitle($crawler),
                'meta_description' => $this->extractMetaDescription($crawler),
                'all_links' => $this->extractAllLinks($crawler),
                'images' => $this->extractImages($crawler),
                'headers' => $this->extractHeaders($crawler),
            ];

            // Extract custom selectors if provided
            if (!empty($selectors)) {
                foreach ($selectors as $key => $selector) {
                    $data['custom'][$key] = $this->extractBySelector($crawler, $selector);
                }
            }

            // Extract text content
            $data['content'] = $this->extractContent($crawler);

            return [
                'success' => true,
                'data' => $data,
                'status_code' => $response->getStatusCode()
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    private function extractTitle(Crawler $crawler)
    {
        return $crawler->filter('title')->count() > 0 
            ? $crawler->filter('title')->text() 
            : 'No title found';
    }

    private function extractMetaDescription(Crawler $crawler)
    {
        $description = '';
        if ($crawler->filter('meta[name="description"]')->count() > 0) {
            $description = $crawler->filter('meta[name="description"]')->attr('content');
        }
        return $description;
    }

    private function extractAllLinks(Crawler $crawler)
    {
        $links = [];
        $crawler->filter('a')->each(function (Crawler $node) use (&$links) {
            $href = $node->attr('href');
            $text = trim($node->text());
            if ($href) {
                $links[] = [
                    'url' => $href,
                    'text' => $text ?: 'No text',
                    'is_internal' => $this->isInternalLink($href)
                ];
            }
        });
        return array_slice($links, 0, 50); // Limit to 50 links
    }

    private function extractImages(Crawler $crawler)
    {
        $images = [];
        $crawler->filter('img')->each(function (Crawler $node) use (&$images) {
            $src = $node->attr('src');
            $alt = $node->attr('alt');
            if ($src) {
                $images[] = [
                    'src' => $src,
                    'alt' => $alt ?: 'No alt text',
                    'width' => $node->attr('width'),
                    'height' => $node->attr('height')
                ];
            }
        });
        return array_slice($images, 0, 20); // Limit to 20 images
    }

    private function extractHeaders(Crawler $crawler)
    {
        $headers = [];
        for ($i = 1; $i <= 6; $i++) {
            $headers["h{$i}"] = [];
            $crawler->filter("h{$i}")->each(function (Crawler $node) use (&$headers, $i) {
                $headers["h{$i}"][] = trim($node->text());
            });
        }
        return $headers;
    }

    private function extractBySelector(Crawler $crawler, $selector)
    {
        $results = [];
        if ($crawler->filter($selector)->count() > 0) {
            $crawler->filter($selector)->each(function (Crawler $node) use (&$results) {
                $results[] = trim($node->text());
            });
        }
        return $results;
    }

    private function extractContent(Crawler $crawler)
    {
        $content = [];
        
        // Get all paragraphs
        $crawler->filter('p')->each(function (Crawler $node) use (&$content) {
            $text = trim($node->text());
            if (!empty($text)) {
                $content['paragraphs'][] = $text;
            }
        });

        // Get first 1000 characters of main text
        $allText = $crawler->filter('body')->text();
        $content['summary'] = substr(trim($allText), 0, 1000) . '...';

        return $content;
    }

    private function isInternalLink($link)
    {
        // Simple check - can be enhanced
        return !filter_var($link, FILTER_VALIDATE_URL) || 
               strpos($link, 'http') !== 0;
    }

    public function saveScrapedData($url, $result, $title = null)
    {
        $data = [
            'url' => $url,
            'title' => $title ?: ($result['success'] ? $result['data']['title'] : 'Scraping Failed'),
            'description' => $result['success'] ? $result['data']['meta_description'] : null,
            'data' => $result['success'] ? $result['data'] : null,
            'status' => $result['success'] ? 'completed' : 'failed',
            'scraped_at' => $result['success'] ? now() : null
        ];

        return ScrapedData::create($data);
    }
}