<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            [
                'name' => 'BBC News',
                'url' => 'http://feeds.bbci.co.uk/news/rss.xml',
                'type' => 'rss',
                'is_active' => true
            ],
            [
                'name' => 'TechCrunch',
                'url' => 'https://techcrunch.com/feed/',
                'type' => 'rss',
                'is_active' => true
            ],
            [
                'name' => 'Reuters',
                'url' => 'https://www.reutersagency.com/feed/?best-topics=tech&post_type=best',
                'type' => 'rss',
                'is_active' => true
            ]
        ];

        foreach ($sources as $source) {
            Source::create($source);
        }
    }
}