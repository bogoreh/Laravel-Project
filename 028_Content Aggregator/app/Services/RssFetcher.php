<?php

namespace App\Services;

use App\Models\Source;
use App\Models\Article;
use SimpleXMLElement;

class RssFetcher
{
    public function fetch(Source $source)
    {
        $xml = simplexml_load_file($source->url);
        
        if (!$xml) {
            return false;
        }

        $items = $xml->channel->item ?? $xml->item ?? [];

        foreach ($items as $item) {
            $this->createArticle($source, $item);
        }

        return true;
    }

    private function createArticle(Source $source, SimpleXMLElement $item)
    {
        $namespace = $item->getNamespaces(true);
        
        $articleData = [
            'title' => (string) $item->title,
            'description' => (string) $item->description,
            'url' => (string) $item->link,
            'author' => (string) ($item->author ?? $item->children($namespace['dc'])->creator ?? null),
            'published_at' => $this->parseDate($item->pubDate),
            'category' => (string) ($item->category ?? null),
            'content' => (string) ($item->children($namespace['content'])->encoded ?? null),
        ];

        // Check if image exists in media namespace
        if (isset($namespace['media'])) {
            $media = $item->children($namespace['media']);
            if ($media->content && $media->content->attributes()) {
                $articleData['image_url'] = (string) $media->content->attributes()->url;
            }
        }

        // Avoid duplicates
        Article::updateOrCreate(
            ['source_id' => $source->id, 'url' => $articleData['url']],
            $articleData
        );
    }

    private function parseDate($dateString)
    {
        try {
            return date('Y-m-d H:i:s', strtotime((string) $dateString));
        } catch (\Exception $e) {
            return now();
        }
    }
}