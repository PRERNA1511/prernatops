@extends('layouts.assignment')

@section('title', 'Session 15: Eloquent Advanced')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 15</span> Advanced Eloquent, Scopes &amp; Raw SQL</h2>
    <p class="text-muted">Local query scopes, model accessors &amp; mutators, Query Builder fluent API, and safe parameterized raw SQL queries.</p>
</div>

<div class="row g-4">
    <!-- Query Scopes & Accessors -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-funnel text-primary me-2"></i> Query Scope &amp; Accessors
            </div>
            <div class="card-body">
                <h6 class="fw-bold small text-muted">1. Local Query Scope: <code>Playlist::public()</code></h6>
                <div class="code-block small mb-3">
// Defined on Playlist Model:
public function scopePublic($query) {
    return $query->where('is_public', true);
}
// Invoked as:
$publicPlaylists = Playlist::public()->get();
                </div>

                <h6 class="fw-bold small text-muted">2. Accessor: <code>formatted_duration</code> &amp; <code>cover_url</code></h6>
                @if($sampleSong)
                    <div class="p-2 border rounded bg-light mb-2">
                        <strong>Raw DB Duration:</strong> {{ $sampleSong->duration_seconds }} seconds<br>
                        <strong>Formatted Accessor:</strong> <span class="badge bg-success">{{ $sampleSong->formatted_duration }} min</span>
                    </div>
                @endif
                @if($samplePlaylist)
                    <div class="p-2 border rounded bg-light">
                        <strong>Formatted Date Accessor:</strong> {{ $samplePlaylist->formatted_created_at }}<br>
                        <strong>Mutator:</strong> <code>setNameAttribute()</code> automatically applies <code>ucwords()</code> on save.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Query Builder & Raw SQL -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-database text-success me-2"></i> Query Builder &amp; Parameterized Raw SQL
            </div>
            <div class="card-body">
                <h6 class="fw-bold small text-muted">1. Query Builder (Songs > 200s):</h6>
                <ul class="list-group list-group-flush border rounded mb-3">
                    @foreach($queryBuilderResults as $song)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 small">
                            <span>{{ $song->title }} ({{ $song->artist }})</span>
                            <span class="badge bg-dark">{{ $song->duration_seconds }}s</span>
                        </li>
                    @endforeach
                </ul>

                <h6 class="fw-bold small text-muted">2. Raw SQL (Group By Count):</h6>
                <div class="code-block small mb-2">
DB::select("SELECT genres.name, COUNT(playlists.id) AS count FROM genres LEFT JOIN playlists ON ...");
                </div>
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Genre</th>
                            <th class="text-end">Playlist Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rawSqlResults as $row)
                            <tr>
                                <td>{{ $row->genre_name }}</td>
                                <td class="text-end fw-bold">{{ $row->playlist_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
