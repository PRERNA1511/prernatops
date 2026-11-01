<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            ['name' => 'Pop', 'description' => 'Upbeat and catchy contemporary popular music.'],
            ['name' => 'Rock', 'description' => 'Classic and modern rock music with energetic guitar riffs.'],
            ['name' => 'Jazz', 'description' => 'Smooth chords, improvisation, and classic swing rhythms.'],
            ['name' => 'Hip Hop', 'description' => 'Rhythmic beats, lyrical flow, and modern urban sound.'],
            ['name' => 'Classical', 'description' => 'Orchestral, piano melodies, and timeless acoustic arrangements.'],
            ['name' => 'Electronic', 'description' => 'Synthesizers, dance grooves, and ambient electronic vibes.'],
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(
                ['slug' => Str::slug($genre['name'])],
                [
                    'name' => $genre['name'],
                    'description' => $genre['description'],
                ]
            );
        }
    }
}
