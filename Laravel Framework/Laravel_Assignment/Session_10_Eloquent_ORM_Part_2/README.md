# Session 10: Eloquent Relationships & Eager vs Lazy Loading

## Session Overview
Session 10 covers the three primary types of Eloquent database relationships: One-to-One, One-to-Many, and Many-to-Many. It also explains the N+1 query problem and how Eager Loading (`with()`) resolves it.

---

## Practical Tasks & Implementation

### Task 1: One-to-One Relationship
- Model: `User::hasOne(UserProfile::class)` and inverse `UserProfile::belongsTo(User::class)`.
- Foreign key: `user_id` on the `user_profiles` table.

### Task 2: One-to-Many Relationship
- Model: `Genre::hasMany(Playlist::class)` and inverse `Playlist::belongsTo(Genre::class)`.
- Foreign key: `genre_id` on the `playlists` table.

### Task 3: Many-to-Many Relationship with Pivot Table
- Model: `Playlist::belongsToMany(Song::class, 'playlist_song')` and `Song::belongsToMany(Playlist::class, 'playlist_song')`.
- Pivot Table: `playlist_song` storing `playlist_id` and `song_id`.

### Task 4: Eager Loading vs Lazy Loading (Solving N+1)
- **Lazy Loading (Problem):** Querying 3 playlists and then accessing `$playlist->user` and `$playlist->genre` triggers separate queries for each record, executing $1 + (2 \times N)$ queries.
- **Eager Loading (Solution):** Using `Playlist::with('user', 'genre')->get()` executes only 3 queries total regardless of how many playlists are returned.

---

## Files Created & Referenced
- `app/Models/User.php`
- `app/Models/UserProfile.php`
- `app/Models/Genre.php`
- `app/Models/Playlist.php`
- `app/Models/Song.php`
- `app/Http/Controllers/SessionSixToTenController.php` (`session10()`)
- `resources/views/assignment/sessions/session10.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-10`.
2. Inspect the Three Relationship demo cards (One-to-One, One-to-Many, Many-to-Many).
3. Review the Eager Loading vs Lazy Loading query count comparison.
