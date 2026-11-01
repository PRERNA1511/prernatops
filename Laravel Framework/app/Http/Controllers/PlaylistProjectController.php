<?php

namespace App\Http\Controllers;

use App\Events\PlaylistCreated;
use App\Http\Requests\StorePlaylistRequest;
use App\Mail\WelcomeNotificationMail;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\PlaylistLike;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PlaylistProjectController extends Controller
{
    /**
     * Session 24: Mini Project - Display listing of all public playlists.
     */
    public function index(Request $request)
    {
        $genres = Genre::all();
        $selectedGenre = $request->input('genre');
        $searchTerm = $request->input('search');

        $query = Playlist::with('user', 'genre', 'songs', 'likes')->latest();

        if (!empty($selectedGenre)) {
            $query->where('genre_id', $selectedGenre);
        }

        if (!empty($searchTerm)) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $playlists = $query->paginate(9);

        $userPlaylists = Auth::check() 
            ? Playlist::where('user_id', Auth::id())->with('genre', 'songs')->get() 
            : collect();

        return view('assignment.mini_project.index', compact('playlists', 'genres', 'selectedGenre', 'searchTerm', 'userPlaylists'));
    }

    /**
     * Session 24: Show form for creating a new playlist.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('session.13')->with('info', 'Please log in or register to create a new playlist.');
        }

        $genres = Genre::all();
        $songs = Song::all();

        return view('assignment.mini_project.create', compact('genres', 'songs'));
    }

    /**
     * Session 24: Store a new playlist with image upload, event, and email notification.
     */
    public function store(StorePlaylistRequest $request)
    {
        $user = Auth::user() ?? User::first();

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = 'cover_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $coverPath = $file->storeAs('covers', $filename, 'public');
        }

        $playlist = Playlist::create([
            'user_id' => $user->id,
            'genre_id' => $request->input('genre_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'cover_image' => $coverPath,
            'is_public' => $request->boolean('is_public', true),
        ]);

        // Attach selected songs if any
        if ($request->has('songs')) {
            $playlist->songs()->sync($request->input('songs'));
        }

        // 1. Trigger PlaylistCreated Event
        event(new PlaylistCreated($playlist));

        // 2. Dispatch Email Notification using Mailable
        if (!empty($user->email)) {
            try {
                Mail::to($user->email)->send(new WelcomeNotificationMail($user, "Your playlist '{$playlist->name}' was created successfully in Mini Project!"));
            } catch (\Exception $e) {
                // Email logged or suppressed gracefully in local development
            }
        }

        return redirect()->route('playlist.show', $playlist->id)->with('success', "Playlist '{$playlist->name}' created successfully with cover image and notification!");
    }

    /**
     * Session 24: Display details of a single playlist.
     */
    public function show($id)
    {
        $playlist = Playlist::with('user', 'genre', 'songs', 'likes')->findOrFail($id);
        $availableSongs = Song::whereNotIn('id', $playlist->songs->pluck('id'))->get();
        $isLiked = Auth::check() ? $playlist->likes->contains('id', Auth::id()) : false;

        return view('assignment.mini_project.show', compact('playlist', 'availableSongs', 'isLiked'));
    }

    /**
     * Session 24: Show form for editing an existing playlist.
     */
    public function edit($id)
    {
        $playlist = Playlist::findOrFail($id);

        if (!Auth::check() || ($playlist->user_id !== Auth::id() && !Auth::user()->isAdmin())) {
            return redirect()->route('playlist.show', $id)->with('error', 'Unauthorized: You can only edit playlists you created.');
        }

        $genres = Genre::all();

        return view('assignment.mini_project.edit', compact('playlist', 'genres'));
    }

    /**
     * Session 24: Update playlist details.
     */
    public function update(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);

        if (!Auth::check() || ($playlist->user_id !== Auth::id() && !Auth::user()->isAdmin())) {
            return redirect()->route('playlist.show', $id)->with('error', 'Unauthorized: You can only update your own playlist.');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_public' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($playlist->cover_image && Storage::disk('public')->exists($playlist->cover_image)) {
                Storage::disk('public')->delete($playlist->cover_image);
            }
            $file = $request->file('cover_image');
            $filename = 'cover_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $playlist->cover_image = $file->storeAs('covers', $filename, 'public');
        }

        $playlist->name = $request->input('name');
        $playlist->genre_id = $request->input('genre_id');
        $playlist->description = $request->input('description');
        $playlist->is_public = $request->boolean('is_public', true);
        $playlist->save();

        return redirect()->route('playlist.show', $playlist->id)->with('success', 'Playlist updated successfully!');
    }

    /**
     * Session 24: Delete a playlist.
     */
    public function destroy($id)
    {
        $playlist = Playlist::findOrFail($id);

        if (!Auth::check() || ($playlist->user_id !== Auth::id() && !Auth::user()->isAdmin())) {
            return redirect()->route('playlist.index')->with('error', 'Unauthorized: You cannot delete this playlist.');
        }

        if ($playlist->cover_image && Storage::disk('public')->exists($playlist->cover_image)) {
            Storage::disk('public')->delete($playlist->cover_image);
        }

        $playlist->delete();

        return redirect()->route('playlist.index')->with('success', "Playlist '{$playlist->name}' was deleted successfully.");
    }

    /**
     * Session 24: Attach a song to a playlist.
     */
    public function addSong(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);

        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        $playlist->songs()->syncWithoutDetaching([$request->input('song_id')]);

        return redirect()->route('playlist.show', $id)->with('success', 'Song added to playlist successfully!');
    }

    /**
     * Session 24: Detach a song from a playlist.
     */
    public function removeSong($id, $songId)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->songs()->detach($songId);

        return redirect()->route('playlist.show', $id)->with('success', 'Song removed from playlist.');
    }

    /**
     * Session 24: Toggle Like / Favorite on playlist.
     */
    public function toggleLike($id)
    {
        if (!Auth::check()) {
            return redirect()->route('session.13')->with('error', 'Please log in to like playlists.');
        }

        $user = Auth::user();
        $playlist = Playlist::findOrFail($id);

        $like = PlaylistLike::where('user_id', $user->id)->where('playlist_id', $playlist->id)->first();
        if ($like) {
            $like->delete();
            $msg = 'Playlist unliked.';
        } else {
            PlaylistLike::create([
                'user_id' => $user->id,
                'playlist_id' => $playlist->id,
            ]);
            $msg = 'Playlist liked!';
        }

        return back()->with('success', $msg);
    }
}
