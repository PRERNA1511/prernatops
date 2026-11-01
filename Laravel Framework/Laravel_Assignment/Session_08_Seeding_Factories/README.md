# Session 8: Factories, Faker, Seeders & Sample Data

## Session Overview
Session 8 demonstrates automated test data generation using Model Factories powered by the PHP Faker library, and populating tables using dedicated Database Seeders.

---

## Practical Tasks & Implementation

### Task 1: Model Factories
- `database/factories/UserFactory.php`: Generates realistic names, usernames, safe emails, and hashed passwords.
- `database/factories/GenreFactory.php`: Generates unique genre names, slugs, and descriptions.
- `database/factories/PlaylistFactory.php`: Generates playlists linked to users and genres.
- `database/factories/SongFactory.php`: Generates track titles, artists, albums, and duration in seconds.

### Task 2: Database Seeders
- `database/seeders/GenreSeeder.php`: Seeds Pop, Rock, Jazz, Hip Hop, Classical, Electronic.
- `database/seeders/SongSeeder.php`: Seeds 10 popular songs with realistic artists, albums, and durations.
- `database/seeders/DatabaseSeeder.php`: Orchestrates all seeders, creates default `admin` and `student` users, links sample playlists, and establishes initial likes.

### Task 3: Seeder Execution
- Ran `php artisan db:seed` to populate the database.

---

## Files Created & Referenced
- `database/factories/UserFactory.php`
- `database/factories/GenreFactory.php`
- `database/factories/PlaylistFactory.php`
- `database/factories/SongFactory.php`
- `database/seeders/GenreSeeder.php`
- `database/seeders/SongSeeder.php`
- `database/seeders/DatabaseSeeder.php`
- `resources/views/assignment/sessions/session08.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-08`.
2. Inspect the live counts of seeded users, genres, playlists, and songs, along with the seeded song table.
