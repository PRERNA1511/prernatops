<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaylistRequest;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\PlaylistLike;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SessionElevenToFifteenController extends Controller
{
    /**
     * Session 11: Validation rules, custom messages, Form Request class.
     */
    public function session11()
    {
        $genres = Genre::all();
        $songs = Song::take(5)->get();
        return view('assignment.sessions.session11', compact('genres', 'songs'));
    }

    /**
     * Store using Form Request validation (Session 11).
     */
    public function session11Store(StorePlaylistRequest $request)
    {
        $user = Auth::user() ?? User::first();

        $playlist = Playlist::create([
            'user_id' => $user->id,
            'genre_id' => $request->input('genre_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_public' => true,
        ]);

        return redirect()->route('session.11')->with('success', "Form Request validation passed! Playlist '{$playlist->name}' was created.");
    }

    /**
     * Session 12: File Uploads, Validation, Storage Disk, and Gallery.
     */
    public function session12()
    {
        // Scan public gallery directory
        $galleryImages = Storage::disk('public')->files('gallery');
        return view('assignment.sessions.session12', compact('galleryImages'));
    }

    /**
     * Process File Upload (Session 12).
     */
    public function session12Upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $filename, 'public');

            return redirect()->route('session.12')->with('success', "File uploaded successfully to storage/app/public/{$path}!");
        }

        return redirect()->route('session.12')->with('error', 'File upload failed.');
    }

    /**
     * Session 13: Authentication Setup, Custom Registration (username), Login, Protected Routes.
     */
    public function session13()
    {
        $currentUser = Auth::user();
        $usersList = User::latest()->take(5)->get();
        return view('assignment.sessions.session13', compact('currentUser', 'usersList'));
    }

    /**
     * Custom User Registration (Session 13).
     */
    public function session13Register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|min:3|max:30|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('session.13')->with('success', "Registration successful! Welcome {$user->username}. You are now authenticated.");
    }

    /**
     * Session 14: Login Customization (Username or Email), Logout, Wishlist Protection.
     */
    public function session14()
    {
        $currentUser = Auth::user();
        $playlists = Playlist::with('user', 'genre')->get();
        $likedPlaylistIds = $currentUser ? $currentUser->likedPlaylists->pluck('id')->toArray() : [];

        return view('assignment.sessions.session14', compact('currentUser', 'playlists', 'likedPlaylistIds'));
    }

    /**
     * Custom Login Action (Session 14 - supports username or email).
     */
    public function session14Login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if login input is email or username
        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginField => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->route('session.14')->with('success', "Logged in successfully as " . Auth::user()->name . "!");
        }

        return back()->withErrors(['login' => 'Invalid credentials provided.'])->withInput();
    }

    /**
     * Logout action (Session 14).
     */
    public function session14Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('session.14')->with('info', 'You have been logged out successfully.');
    }

    /**
     * Toggle Wishlist / Like (Session 14 & 24). Protected by auth.
     */
    public function session14ToggleWishlist(Request $request, $playlistId)
    {
        if (!Auth::check()) {
            return redirect()->route('session.14')->with('error', 'Authentication required! Please log in to manage your wishlist.');
        }

        $user = Auth::user();
        $playlist = Playlist::findOrFail($playlistId);

        $exists = PlaylistLike::where('user_id', $user->id)->where('playlist_id', $playlist->id)->first();
        if ($exists) {
            $exists->delete();
            $msg = "Removed '{$playlist->name}' from your wishlist/favorites.";
        } else {
            PlaylistLike::create([
                'user_id' => $user->id,
                'playlist_id' => $playlist->id,
            ]);
            $msg = "Added '{$playlist->name}' to your wishlist/favorites!";
        }

        return back()->with('success', $msg);
    }

    /**
     * Session 15: Query Scopes, Accessors, Mutators, Query Builder, Raw SQL.
     */
    public function session15()
    {
        // 1. Query Scope demonstration (scopePublic)
        $publicPlaylists = Playlist::public()->get();

        // 2. Query Builder demonstration
        $queryBuilderResults = DB::table('songs')
            ->select('id', 'title', 'artist', 'duration_seconds')
            ->where('duration_seconds', '>', 200)
            ->orderBy('duration_seconds', 'desc')
            ->get();

        // 3. Raw SQL demonstration (safe parameterized query)
        $rawSqlResults = DB::select(
            'SELECT genres.name AS genre_name, COUNT(playlists.id) AS playlist_count 
             FROM genres 
             LEFT JOIN playlists ON genres.id = playlists.genre_id 
             GROUP BY genres.id, genres.name'
        );

        // 4. Accessor & Mutator demonstration
        $sampleSong = Song::first();
        $samplePlaylist = Playlist::first();

        return view('assignment.sessions.session15', compact(
            'publicPlaylists',
            'queryBuilderResults',
            'rawSqlResults',
            'sampleSong',
            'samplePlaylist'
        ));
    }
}
