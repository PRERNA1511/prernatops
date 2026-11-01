<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class AjaxSongController extends Controller
{
    /**
     * Session 21: Render the interactive AJAX Song Search page.
     */
    public function index()
    {
        $allSongsCount = Song::count();
        return view('assignment.sessions.session21', compact('allSongsCount'));
    }

    /**
     * Session 21: AJAX endpoint returning JSON search results.
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (empty($query)) {
            // Return top 5 default songs if query is blank
            $songs = Song::take(5)->get();
        } else {
            $songs = Song::search($query)->take(10)->get();
        }

        return response()->json([
            'status' => 'success',
            'query' => $query,
            'count' => $songs->count(),
            'data' => $songs->map(function ($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist,
                    'album' => $song->album ?? 'Single',
                    'duration' => $song->formatted_duration,
                ];
            }),
        ]);
    }
}
