@extends('layouts.assignment')

@section('title', 'Session 10: Eloquent Relationships & Eager Loading')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 10</span> Eloquent Relationships &amp; N+1 Optimization</h2>
    <p class="text-muted">Defining One-to-One, One-to-Many, and Many-to-Many relationships, comparing Lazy Loading vs Eager Loading (<code>with()</code>).</p>
</div>

<div class="row g-4">
    <!-- 1. One to One -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-person-badge text-primary me-2"></i> 1. One-to-One
            </div>
            <div class="card-body">
                <div class="small text-muted mb-2"><code>User hasOne UserProfile</code></div>
                @if($userWithProfile)
                    <div class="p-2 border rounded bg-light">
                        <strong>User:</strong> {{ $userWithProfile->name }}<br>
                        <strong>Phone:</strong> {{ $userWithProfile->profile->phone ?? 'N/A' }}<br>
                        <strong>City:</strong> {{ $userWithProfile->profile->city ?? 'N/A' }}<br>
                        <strong>Bio:</strong> <span class="small text-muted">{{ $userWithProfile->profile->bio ?? 'N/A' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. One to Many -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-tags text-success me-2"></i> 2. One-to-Many
            </div>
            <div class="card-body">
                <div class="small text-muted mb-2"><code>Genre hasMany Playlists</code></div>
                @if($genreWithPlaylists)
                    <div class="p-2 border rounded bg-light">
                        <strong>Genre:</strong> {{ $genreWithPlaylists->name }}<br>
                        <strong>Total Playlists:</strong> {{ $genreWithPlaylists->playlists->count() }}
                        <ul class="small mb-0 mt-2 ps-3">
                            @foreach($genreWithPlaylists->playlists as $pl)
                                <li>{{ $pl->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 3. Many to Many -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-diagram-2 text-warning me-2"></i> 3. Many-to-Many
            </div>
            <div class="card-body">
                <div class="small text-muted mb-2"><code>Playlist belongsToMany Songs</code></div>
                @if($playlistWithSongs)
                    <div class="p-2 border rounded bg-light">
                        <strong>Playlist:</strong> {{ $playlistWithSongs->name }}<br>
                        <strong>Songs Linked:</strong> {{ $playlistWithSongs->songs->count() }}
                        <ul class="small mb-0 mt-2 ps-3">
                            @foreach($playlistWithSongs->songs as $song)
                                <li>{{ $song->title }} ({{ $song->artist }})</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Eager Loading vs Lazy Loading Comparison -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-lightning-charge text-danger me-2"></i> Eager Loading vs. Lazy Loading (N+1 Query Problem)
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-bold text-success"><i class="bi bi-check-circle"></i> Eager Loading with with('user', 'genre')</h6>
                            <p class="small text-muted mb-2">Queries executed: <strong>{{ count($eagerQueries) }}</strong> (constant, no N+1 problem)</p>
                            <div class="code-block small">
$playlists = Playlist::with('user', 'genre')->take(3)->get();
// Executes only 3 database queries regardless of count!
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle"></i> Lazy Loading (N+1 Problem)</h6>
                            <p class="small text-muted mb-2">Queries executed: <strong>{{ count($lazyQueries) }}</strong> (1 for playlists + 2 per playlist row)</p>
                            <div class="code-block small">
$playlists = Playlist::take(3)->get();
foreach ($playlists as $p) {
    echo $p->user->name; // Triggers a separate SQL query per row!
}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
