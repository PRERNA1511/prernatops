# Session 7: Migrations, Schema Changes & Foreign Keys

## Session Overview
Migrations serve as version control for the database schema, enabling developers to modify, share, and synchronize database table definitions across team environments without writing manual SQL scripts.

---

## Practical Tasks & Implementation

### Task 1: Creating Migration Files
- Generated migration files using `php artisan make:migration create_[table]_table`.
- Created tables:
  1. `users` (Authentication & roles)
  2. `user_profiles` (One-to-one with users)
  3. `genres` (Music genres)
  4. `playlists` (Playlists with cover artwork)
  5. `songs` (Song tracks)
  6. `playlist_song` (Many-to-many pivot)
  7. `playlist_likes` (Wishlists / favorites)

### Task 2: Foreign Key Constraints & Cascade Operations
- Defined relational integrity using `foreignId()`:
  ```php
  $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
  $table->foreignId('genre_id')->nullable()->constrained('genres')->nullOnDelete();
  ```

### Task 3: Migration Execution & Rollback
- Executed migrations: `php artisan migrate`
- Documented rollback operations: `php artisan migrate:rollback`, `migrate:reset`, `migrate:refresh`.

---

## Files Created & Referenced
- `database/migrations/2014_10_12_000000_create_users_table.php`
- `database/migrations/2026_01_01_000001_create_user_profiles_table.php`
- `database/migrations/2026_01_01_000002_create_genres_table.php`
- `database/migrations/2026_01_01_000003_create_playlists_table.php`
- `database/migrations/2026_01_01_000004_create_songs_table.php`
- `database/migrations/2026_01_01_000005_create_playlist_song_table.php`
- `database/migrations/2026_01_01_000006_create_playlist_likes_table.php`
- `resources/views/assignment/sessions/session07.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-07` to view the migrated tables and their roles.
2. In terminal, run `php artisan migrate:status` to verify migration batches.
