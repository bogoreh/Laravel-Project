<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Track;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Create Artists
        $artists = [
            [
                'name' => 'The Weeknd',
                'genre' => 'R&B',
                'bio' => 'Canadian singer, songwriter, and record producer.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/33/The_Weeknd_%2830261617193%29.jpg/320px-The_Weeknd_%2830261617193%29.jpg'
            ],
            [
                'name' => 'Taylor Swift',
                'genre' => 'Pop',
                'bio' => 'American singer-songwriter known for narrative songwriting.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Taylor_Swift_%2848662080692%29.jpg/320px-Taylor_Swift_%2848662080692%29.jpg'
            ],
            [
                'name' => 'Kendrick Lamar',
                'genre' => 'Hip Hop',
                'bio' => 'American rapper and songwriter regarded as one of the most influential artists of his generation.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2b/Kendrick_Lamar_%288366273476%29.jpg/320px-Kendrick_Lamar_%288366273476%29.jpg'
            ],
            [
                'name' => 'Billie Eilish',
                'genre' => 'Alternative',
                'bio' => 'American singer and songwriter known for her unique vocal style.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Billie_Eilish_%2848662080692%29.jpg/320px-Billie_Eilish_%2848662080692%29.jpg'
            ]
        ];

        foreach ($artists as $artistData) {
            $artist = Artist::create($artistData);
            
            // Create albums for each artist
            $albums = [];
            
            if ($artist->name === 'The Weeknd') {
                $albums = [
                    [
                        'title' => 'After Hours',
                        'price' => 19.99,
                        'stock_quantity' => 50,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Weeknd_-_After_Hours.png',
                        'genre' => 'R&B',
                        'release_year' => 2020
                    ],
                    [
                        'title' => 'Dawn FM',
                        'price' => 21.99,
                        'stock_quantity' => 30,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/9/9a/The_Weeknd_-_Dawn_FM.png',
                        'genre' => 'R&B',
                        'release_year' => 2022
                    ]
                ];
            } elseif ($artist->name === 'Taylor Swift') {
                $albums = [
                    [
                        'title' => 'Folklore',
                        'price' => 22.99,
                        'stock_quantity' => 100,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/f/f8/Taylor_Swift_-_Folklore.png',
                        'genre' => 'Indie Folk',
                        'release_year' => 2020
                    ],
                    [
                        'title' => 'Midnights',
                        'price' => 24.99,
                        'stock_quantity' => 75,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/9/9f/Midnights_-_Taylor_Swift.png',
                        'genre' => 'Pop',
                        'release_year' => 2022
                    ]
                ];
            } elseif ($artist->name === 'Kendrick Lamar') {
                $albums = [
                    [
                        'title' => 'DAMN.',
                        'price' => 18.99,
                        'stock_quantity' => 60,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/5/51/Kendrick_Lamar_-_Damn.png',
                        'genre' => 'Hip Hop',
                        'release_year' => 2017
                    ],
                    [
                        'title' => 'good kid, m.A.A.d city',
                        'price' => 17.99,
                        'stock_quantity' => 45,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/2/22/Kendrick_Lamar_-_Good_Kid%2C_M.A.A.D_City.png',
                        'genre' => 'Hip Hop',
                        'release_year' => 2012
                    ]
                ];
            } elseif ($artist->name === 'Billie Eilish') {
                $albums = [
                    [
                        'title' => 'Happier Than Ever',
                        'price' => 20.99,
                        'stock_quantity' => 80,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/3/3c/Billie_Eilish_-_Happier_Than_Ever.png',
                        'genre' => 'Alternative',
                        'release_year' => 2021
                    ],
                    [
                        'title' => 'When We All Fall Asleep, Where Do We Go?',
                        'price' => 19.99,
                        'stock_quantity' => 55,
                        'cover_image' => 'https://upload.wikimedia.org/wikipedia/en/3/38/When_We_All_Fall_Asleep%2C_Where_Do_We_Go%3F.png',
                        'genre' => 'Alternative',
                        'release_year' => 2019
                    ]
                ];
            }
            
            foreach ($albums as $albumData) {
                $album = Album::create(array_merge($albumData, ['artist_id' => $artist->id]));
                
                // Create tracks for each album
                $tracks = [];
                
                if ($album->title === 'After Hours') {
                    $tracks = [
                        ['title' => 'Alone Again', 'duration' => 262, 'track_number' => 1],
                        ['title' => 'Too Late', 'duration' => 220, 'track_number' => 2],
                        ['title' => 'Hardest To Love', 'duration' => 198, 'track_number' => 3],
                        ['title' => 'Scared To Live', 'duration' => 212, 'track_number' => 4],
                        ['title' => 'Snowchild', 'duration' => 240, 'track_number' => 5],
                    ];
                } elseif ($album->title === 'Dawn FM') {
                    $tracks = [
                        ['title' => 'Dawn FM', 'duration' => 86, 'track_number' => 1],
                        ['title' => 'Gasoline', 'duration' => 231, 'track_number' => 2],
                        ['title' => 'How Do I Make You Love Me?', 'duration' => 196, 'track_number' => 3],
                        ['title' => 'Take My Breath', 'duration' => 339, 'track_number' => 4],
                        ['title' => 'Sacrifice', 'duration' => 188, 'track_number' => 5],
                    ];
                }
                
                foreach ($tracks as $trackData) {
                    Track::create(array_merge($trackData, ['album_id' => $album->id]));
                }
            }
        }
    }
}