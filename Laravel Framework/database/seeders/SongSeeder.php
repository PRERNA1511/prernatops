<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    public function run()
    {
        $songs = [
            ['title' => 'Blinding Lights', 'artist' => 'The Weeknd', 'album' => 'After Hours', 'duration_seconds' => 200],
            ['title' => 'Bohemian Rhapsody', 'artist' => 'Queen', 'album' => 'A Night at the Opera', 'duration_seconds' => 354],
            ['title' => 'Shape of You', 'artist' => 'Ed Sheeran', 'album' => 'Divide', 'duration_seconds' => 233],
            ['title' => 'Hotel California', 'artist' => 'Eagles', 'album' => 'Hotel California', 'duration_seconds' => 390],
            ['title' => 'Take Five', 'artist' => 'Dave Brubeck', 'album' => 'Time Out', 'duration_seconds' => 324],
            ['title' => 'Fly Me to the Moon', 'artist' => 'Frank Sinatra', 'album' => 'It Might as Well Be Swing', 'duration_seconds' => 147],
            ['title' => 'Lose Yourself', 'artist' => 'Eminem', 'album' => '8 Mile', 'duration_seconds' => 326],
            ['title' => 'Clair de Lune', 'artist' => 'Claude Debussy', 'album' => 'Suite bergamasque', 'duration_seconds' => 302],
            ['title' => 'Midnight City', 'artist' => 'M83', 'album' => 'Hurry Up, We\'re Dreaming', 'duration_seconds' => 244],
            ['title' => 'Levitating', 'artist' => 'Dua Lipa', 'album' => 'Future Nostalgia', 'duration_seconds' => 203],
        ];

        foreach ($songs as $song) {
            Song::firstOrCreate(
                ['title' => $song['title'], 'artist' => $song['artist']],
                $song
            );
        }
    }
}
