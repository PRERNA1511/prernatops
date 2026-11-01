<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'album',
        'duration_seconds',
        'audio_file',
    ];

    /**
     * Relationship: Song belongs to many Playlists.
     */
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')->withTimestamps();
    }

    /**
     * Accessor: Format duration in mm:ss format.
     */
    public function getFormattedDurationAttribute(): string
    {
        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Mutator: Clean title.
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

    /**
     * Scope: Search by title, artist, or album (Session 21 AJAX search).
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                     ->orWhere('artist', 'like', "%{$term}%")
                     ->orWhere('album', 'like', "%{$term}%");
    }
}
