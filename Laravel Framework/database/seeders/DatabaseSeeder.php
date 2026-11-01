<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Genres
        $this->call(GenreSeeder::class);

        // 2. Seed Songs
        $this->call(SongSeeder::class);

        // 3. Seed Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        UserProfile::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'phone' => '+1 555-0199',
                'city' => 'San Francisco',
                'bio' => 'System Administrator managing the Laravel Playlist Application.',
            ]
        );

        // 4. Seed Standard Student User
        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student Learner',
                'username' => 'student',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        UserProfile::firstOrCreate(
            ['user_id' => $student->id],
            [
                'phone' => '+1 555-0144',
                'city' => 'New York',
                'bio' => 'Computer Science student learning Laravel Framework from Session 1 to 25.',
            ]
        );

        // 5. Seed Playlists for Student
        $popGenre = Genre::where('slug', 'pop')->first();
        $rockGenre = Genre::where('slug', 'rock')->first();
        $jazzGenre = Genre::where('slug', 'jazz')->first();

        $p1 = Playlist::firstOrCreate(
            ['name' => 'Morning Energy Pop', 'user_id' => $student->id],
            [
                'genre_id' => $popGenre ? $popGenre->id : null,
                'description' => 'Upbeat hits to jumpstart your morning routine and workouts.',
                'cover_image' => null,
                'is_public' => true,
            ]
        );

        $p2 = Playlist::firstOrCreate(
            ['name' => 'Classic Rock Anthems', 'user_id' => $student->id],
            [
                'genre_id' => $rockGenre ? $rockGenre->id : null,
                'description' => 'Timeless rock tracks featuring legendary guitar solos and vocals.',
                'cover_image' => null,
                'is_public' => true,
            ]
        );

        $p3 = Playlist::firstOrCreate(
            ['name' => 'Late Night Study Jazz', 'user_id' => $admin->id],
            [
                'genre_id' => $jazzGenre ? $jazzGenre->id : null,
                'description' => 'Calm and smooth instrumental jazz for deep study and focus.',
                'cover_image' => null,
                'is_public' => true,
            ]
        );

        // Attach songs to playlists
        $allSongs = Song::all();
        if ($allSongs->count() > 0) {
            $p1->songs()->syncWithoutDetaching($allSongs->slice(0, 3)->pluck('id'));
            $p2->songs()->syncWithoutDetaching($allSongs->slice(1, 3)->pluck('id'));
            $p3->songs()->syncWithoutDetaching($allSongs->slice(4, 3)->pluck('id'));
        }

        // Student likes Admin's playlist
        $student->likedPlaylists()->syncWithoutDetaching([$p3->id]);
    }
}
