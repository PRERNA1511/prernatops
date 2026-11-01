@extends('layouts.assignment')

@section('title', $playlist->name . ' - Mini Project')

@section('content')
<div class="mb-4">
    <a href="{{ route('playlist.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to All Playlists
    </a>
</div>

<!-- Header Card -->
<div class="card mb-4 overflow-hidden shadow-sm">
    <div class="row g-0">
        <div class="col-md-4" style="min-height: 220px; max-height: 260px; overflow: hidden; background: #212529;">
            <img src="{{ $playlist->cover_url }}" alt="{{ $playlist->name }}" class="w-100 h-100" style="object-fit: cover;">
        </div>
        <div class="col-md-8">
            <div class="card-body p-4 d-flex flex-column h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-secondary">{{ $playlist->genre->name ?? 'General' }}</span>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                        <i class="bi bi-heart-fill me-1"></i> {{ $playlist->likes->count() }} Likes
                    </span>
                </div>
                <h2 class="card-title fw-bold h3 mb-2">{{ $playlist->name }}</h2>
                <p class="card-text text-muted mb-3 flex-grow-1">
                    {{ $playlist->description ?: 'No description provided.' }}
                </p>

                <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top text-muted small">
                    <div>
                        <span><i class="bi bi-person"></i> Created by <strong>{{ $playlist->user->name ?? 'System' }}</strong></span> &bull;
                        <span><i class="bi bi-calendar"></i> {{ $playlist->formatted_created_at }}</span>
                    </div>

                    <div class="d-flex gap-2 mt-2 mt-sm-0">
                        <form action="{{ route('playlist.like', $playlist->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $isLiked ? 'btn-danger' : 'btn-outline-danger' }}">
                                <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
                                {{ $isLiked ? 'Liked' : 'Like' }}
                            </button>
                        </form>

                        @if(Auth::check() && ($playlist->user_id === Auth::id() || Auth::user()->isAdmin()))
                            <a href="{{ route('playlist.edit', $playlist->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST" onsubmit="return confirm('Permanently delete this playlist?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Songs Section -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="h6 fw-bold mb-0">
            <i class="bi bi-disc text-primary me-2"></i> Tracklist ({{ $playlist->songs->count() }} songs)
        </h5>
        @if(Auth::check() && ($playlist->user_id === Auth::id() || Auth::user()->isAdmin()))
            <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#addSongCollapse">
                <i class="bi bi-plus-lg me-1"></i> Attach Song
            </button>
        @endif
    </div>

    <!-- Collapsible Add Song Form -->
    <div class="collapse border-bottom bg-light p-3" id="addSongCollapse">
        <form action="{{ route('playlist.addSong', $playlist->id) }}" method="POST" class="row g-2 align-items-center">
            @csrf
            <div class="col-md-9">
                <select name="song_id" class="form-select form-select-sm" required>
                    <option value="">-- Choose a song from database to add --</option>
                    @foreach($availableSongs as $avail)
                        <option value="{{ $avail->id }}">
                            {{ $avail->title }} — {{ $avail->artist }} ({{ $avail->formatted_duration }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success btn-sm w-100">
                    <i class="bi bi-plus-circle me-1"></i> Add to Playlist
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Track Title</th>
                        <th>Artist</th>
                        <th>Album</th>
                        <th>Duration</th>
                        @if(Auth::check() && ($playlist->user_id === Auth::id() || Auth::user()->isAdmin()))
                            <th class="text-end" style="width: 10%;">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($playlist->songs as $index => $song)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $song->title }}</td>
                            <td>{{ $song->artist }}</td>
                            <td class="text-muted">{{ $song->album ?? 'Single' }}</td>
                            <td><code>{{ $song->formatted_duration }}</code></td>
                            @if(Auth::check() && ($playlist->user_id === Auth::id() || Auth::user()->isAdmin()))
                                <td class="text-end">
                                    <form action="{{ route('playlist.removeSong', ['id' => $playlist->id, 'songId' => $song->id]) }}" method="POST" onsubmit="return confirm('Remove track from playlist?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" title="Detach from playlist">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No tracks in this playlist yet. Click "Attach Song" above to add tracks!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
