@extends('layouts.assignment')

@section('title', 'Session 8: Factories & Seeders')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 08</span> Seeders &amp; Model Factories</h2>
    <p class="text-muted">Populating realistic mock records using Faker library, Model Factories, and Database Seeders.</p>
</div>

<div class="row g-4">
    <!-- Seeder Stats -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center bg-white">
                    <div class="h3 fw-bold text-primary mb-0">{{ $usersCount }}</div>
                    <div class="small text-muted">Users Seeded</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center bg-white">
                    <div class="h3 fw-bold text-success mb-0">{{ $genresCount }}</div>
                    <div class="small text-muted">Music Genres</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center bg-white">
                    <div class="h3 fw-bold text-warning mb-0">{{ $playlistsCount }}</div>
                    <div class="small text-muted">Playlists Seeded</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center bg-white">
                    <div class="h3 fw-bold text-info mb-0">{{ $songsCount }}</div>
                    <div class="small text-muted">Songs Seeded</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sample Seeded Songs -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-music-note text-primary me-2"></i> Sample Songs Seeded via SongSeeder
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Track Title</th>
                            <th>Artist</th>
                            <th>Album</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sampleSongs as $song)
                            <tr>
                                <td>{{ $song->title }}</td>
                                <td>{{ $song->artist }}</td>
                                <td>{{ $song->album }}</td>
                                <td><code>{{ $song->formatted_duration }}</code></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Factory Explanation -->
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-magic text-danger me-2"></i> Model Factory Code Example
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Factories utilize the <code>fake()</code> helper to generate test data automatically:
                </p>
                <div class="code-block">
class SongFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'artist' => fake()->name(),
            'album' => fake()->words(2, true),
            'duration_seconds' => fake()->numberBetween(120, 360),
        ];
    }
}
                </div>
                <div class="small text-muted mt-2">
                    Execute seeders anytime via: <code>php artisan db:seed</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
