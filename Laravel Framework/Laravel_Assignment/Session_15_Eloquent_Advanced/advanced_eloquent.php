<?php
// Session 15: Advanced Eloquent Reference Code

namespace LaravelAssignment\Session15;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Facades\DB;

class AdvancedEloquentDemo
{
    public function runDemonstration()
    {
        // 1. Invoking Local Scope
        $publicPlaylists = Playlist::public()->get();

        // 2. Invoking Accessor
        $song = Song::first();
        $formattedDuration = $song->formatted_duration; // e.g. "3:54"

        // 3. Invoking Mutator
        $newPlaylist = new Playlist();
        $newPlaylist->name = 'chill vibes playlist'; // Automatically saved as "Chill Vibes Playlist"

        // 4. Query Builder Fluent API
        $longSongs = DB::table('songs')
            ->select('id', 'title', 'artist')
            ->where('duration_seconds', '>', 240)
            ->get();

        // 5. Safe Parameterized Raw SQL
        $genreId = 1;
        $results = DB::select('SELECT * FROM playlists WHERE genre_id = ? AND is_public = ?', [$genreId, true]);

        return compact('publicPlaylists', 'formattedDuration', 'longSongs', 'results');
    }
}
