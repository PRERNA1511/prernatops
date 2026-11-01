<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaylistApiController extends Controller
{
    /**
     * Session 19: GET /api/playlists - List all playlists with JSON response.
     */
    public function index()
    {
        $playlists = Playlist::with('user:id,name,username', 'genre:id,name,slug', 'songs:id,title,artist,duration_seconds')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Playlists retrieved successfully.',
            'count' => $playlists->count(),
            'data' => $playlists,
        ], 200);
    }

    /**
     * Session 19: POST /api/playlists - Store a new playlist with JSON validation & 201 Created.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string',
            'is_public' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $userId = $request->user() ? $request->user()->id : 1;

        $playlist = Playlist::create([
            'user_id' => $userId,
            'genre_id' => $request->input('genre_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_public' => $request->boolean('is_public', true),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Playlist created successfully.',
            'data' => $playlist->load('genre:id,name'),
        ], 201);
    }

    /**
     * Session 19: GET /api/playlists/{id} - Show specific playlist.
     */
    public function show($id)
    {
        $playlist = Playlist::with('user:id,name,username', 'genre:id,name', 'songs')->find($id);

        if (!$playlist) {
            return response()->json([
                'status' => 'error',
                'message' => "Playlist with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $playlist,
        ], 200);
    }

    /**
     * Session 19: PUT/PATCH /api/playlists/{id} - Update a playlist.
     */
    public function update(Request $request, $id)
    {
        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json([
                'status' => 'error',
                'message' => "Playlist with ID {$id} not found.",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|min:3|max:100',
            'genre_id' => 'sometimes|required|exists:genres,id',
            'description' => 'nullable|string',
            'is_public' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $playlist->update($request->only(['name', 'genre_id', 'description', 'is_public']));

        return response()->json([
            'status' => 'success',
            'message' => 'Playlist updated successfully.',
            'data' => $playlist,
        ], 200);
    }

    /**
     * Session 19: DELETE /api/playlists/{id} - Delete playlist with 200/204 response.
     */
    public function destroy($id)
    {
        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json([
                'status' => 'error',
                'message' => "Playlist with ID {$id} not found.",
            ], 404);
        }

        $playlist->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Playlist deleted successfully.',
        ], 200);
    }
}
