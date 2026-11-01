<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionSixToTenController extends Controller
{
    /**
     * Session 6: Database Configuration & .env Settings.
     */
    public function session6()
    {
        $dbConnection = config('database.default');
        $dbHost = config("database.connections.{$dbConnection}.host", 'localhost');
        $dbDatabase = config("database.connections.{$dbConnection}.database", 'sqlite');
        
        $isConnected = false;
        $connectionMessage = '';

        try {
            DB::connection()->getPdo();
            $isConnected = true;
            $connectionMessage = 'Database connection established successfully!';
        } catch (\Exception $e) {
            $isConnected = false;
            $connectionMessage = 'Connection failed: ' . $e->getMessage();
        }

        return view('assignment.sessions.session06', compact('dbConnection', 'dbHost', 'dbDatabase', 'isConnected', 'connectionMessage'));
    }

    /**
     * Session 7: Migrations, Schema changes, Rollback.
     */
    public function session7()
    {
        // Fetch migrated tables
        $tables = [
            'users' => 'Stores user accounts, authentication credentials, and user roles.',
            'user_profiles' => 'Stores profile bio, city, phone (One-to-One with users).',
            'genres' => 'Music classifications like Pop, Rock, Jazz (One-to-Many with playlists).',
            'playlists' => 'User created playlists with cover images and visibility.',
            'songs' => 'Music track metadata, duration, artist, and album.',
            'playlist_song' => 'Pivot table linking playlists to multiple songs (Many-to-Many).',
            'playlist_likes' => 'Tracks user favorites/wishlists for playlists.',
        ];

        return view('assignment.sessions.session07', compact('tables'));
    }

    /**
     * Session 8: Factories, Faker, Seeders.
     */
    public function session8()
    {
        $usersCount = User::count();
        $genresCount = Genre::count();
        $playlistsCount = Playlist::count();
        $songsCount = Song::count();

        $sampleSongs = Song::take(5)->get();
        $sampleGenres = Genre::take(5)->get();

        return view('assignment.sessions.session08', compact('usersCount', 'genresCount', 'playlistsCount', 'songsCount', 'sampleSongs', 'sampleGenres'));
    }

    /**
     * Session 9: Eloquent CRUD & Debugbar Query Analysis.
     */
    public function session9()
    {
        // Eloquent Read
        $playlists = Playlist::with('user', 'genre')->latest()->get();
        $genres = Genre::all();

        // Sample Query Log demonstration (simulating Debugbar query inspector)
        DB::enableQueryLog();
        $debugbarDemoData = Playlist::with('genre')->take(3)->get();
        $queryLogs = DB::getQueryLog();

        return view('assignment.sessions.session09', compact('playlists', 'genres', 'queryLogs'));
    }

    /**
     * Eloquent Create for Session 9.
     */
    public function session9Store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string',
        ]);

        $defaultUser = User::first();

        // Eloquent Create
        Playlist::create([
            'user_id' => $defaultUser ? $defaultUser->id : 1,
            'genre_id' => $request->input('genre_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_public' => true,
        ]);

        return redirect()->route('session.09')->with('success', 'Playlist created successfully using Eloquent ORM!');
    }

    /**
     * Eloquent Delete for Session 9.
     */
    public function session9Delete($id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->delete();

        return redirect()->route('session.09')->with('success', "Playlist '{$playlist->name}' deleted via Eloquent delete()!");
    }

    /**
     * Session 10: One-to-One, One-to-Many, Many-to-Many Relationships & Eager Loading vs Lazy Loading.
     */
    public function session10()
    {
        // 1. One-to-One: User with Profile
        $userWithProfile = User::with('profile')->first();

        // 2. One-to-Many: Genre with Playlists
        $genreWithPlaylists = Genre::with('playlists')->first();

        // 3. Many-to-Many: Playlist with Songs
        $playlistWithSongs = Playlist::with('songs')->first();

        // 4. Eager Loading vs Lazy Loading demonstration
        // Eager Loading benchmark:
        DB::enableQueryLog();
        DB::flushQueryLog();
        $eagerPlaylists = Playlist::with('user', 'genre')->take(3)->get();
        $eagerQueries = DB::getQueryLog();

        // Lazy Loading benchmark:
        DB::flushQueryLog();
        $rawPlaylists = Playlist::take(3)->get();
        foreach ($rawPlaylists as $p) {
            $u = $p->user ? $p->user->name : null;
            $g = $p->genre ? $p->genre->name : null;
        }
        $lazyQueries = DB::getQueryLog();

        return view('assignment.sessions.session10', compact(
            'userWithProfile',
            'genreWithPlaylists',
            'playlistWithSongs',
            'eagerQueries',
            'lazyQueries'
        ));
    }
}
