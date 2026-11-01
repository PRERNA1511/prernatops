<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre_id',
        'name',
        'description',
        'cover_image',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Relationship: Playlist belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Playlist belongs to a Genre.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Relationship: Playlist has many Songs (Many-to-Many).
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song')->withTimestamps();
    }

    /**
     * Relationship: Users who liked/favorited this playlist.
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'playlist_likes')->withTimestamps();
    }

    /**
     * Query Scope: Filter only public playlists (Session 15 requirement).
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Query Scope: Filter by user ID.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Accessor: Format creation date for UI display.
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('M d, Y') : '';
    }

    /**
     * Accessor: Return full URL or default placeholder image.
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=500&auto=format&fit=crop&q=60';
    }

    /**
     * Mutator: Automatically trim and uppercase first letters (Session 15).
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(trim($value));
    }
}
