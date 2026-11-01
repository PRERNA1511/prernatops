<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * One-to-One relationship: A user has one profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * One-to-Many relationship: A user has many playlists.
     */
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Many-to-Many / Wishlist relationship: Playlists liked by the user.
     */
    public function likedPlaylists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_likes')->withTimestamps();
    }

    /**
     * Helper to check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has liked a playlist.
     */
    public function hasLiked(Playlist $playlist): bool
    {
        return $this->likedPlaylists()->where('playlist_id', $playlist->id)->exists();
    }
}
