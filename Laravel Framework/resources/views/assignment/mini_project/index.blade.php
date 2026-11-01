@extends('layouts.assignment')

@section('title', 'Session 24: Music Playlist Mini Project')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h1 class="h3 fw-bold mb-1 text-dark">
            <i class="bi bi-music-note-list text-danger me-2"></i> Music Playlist Mini Project
        </h1>
        <p class="text-muted mb-0">Browse community playlists, discover songs by genre, like playlists, or create your own collection.</p>
    </div>
    <div class="mt-2 mt-sm-0">
        <a href="{{ route('playlist.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-lg me-1"></i> Create New Playlist
        </a>
    </div>
</div>

<!-- Search & Genre Filter Bar -->
<div class="card mb-4 bg-white">
    <div class="card-body py-3">
        <form action="{{ route('playlist.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search playlists by title..." value="{{ $searchTerm }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="genre" class="form-select">
                    <option value="">All Music Genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ $selectedGenre == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                @if($searchTerm || $selectedGenre)
                    <a href="{{ route('playlist.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Playlists Grid -->
<div class="row g-4 mb-4">
    @forelse($playlists as $playlist)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 overflow-hidden shadow-sm">
                <!-- Cover Image -->
                <div style="height: 180px; overflow: hidden; background: #e9ecef;">
                    <img src="{{ $playlist->cover_url }}" alt="{{ $playlist->name }}" class="w-100 h-100" style="object-fit: cover;">
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary">{{ $playlist->genre->name ?? 'General' }}</span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                            <i class="bi bi-heart-fill me-1"></i> {{ $playlist->likes->count() }} Likes
                        </span>
                    </div>
                    <h5 class="card-title fw-bold h6 mb-1">
                        <a href="{{ route('playlist.show', $playlist->id) }}" class="text-decoration-none text-dark">
                            {{ $playlist->name }}
                        </a>
                    </h5>
                    <p class="card-text text-muted small flex-grow-1 mb-2">
                        {{ Str::limit($playlist->description ?: 'No description provided for this playlist.', 80) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                        <span><i class="bi bi-person"></i> {{ $playlist->user->name ?? 'System' }}</span>
                        <span><i class="bi bi-disc"></i> {{ $playlist->songs->count() }} tracks</span>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top">
                        <a href="{{ route('playlist.show', $playlist->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                            View Playlist
                        </a>
                        <form action="{{ route('playlist.like', $playlist->id) }}" method="POST">
                            @csrf
                            @php
                                $userLiked = Auth::check() && $playlist->likes->contains('id', Auth::id());
                            @endphp
                            <button type="submit" class="btn btn-sm {{ $userLiked ? 'btn-danger' : 'btn-outline-danger' }}" title="{{ $userLiked ? 'Unlike' : 'Like' }}">
                                <i class="bi {{ $userLiked ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card p-5 text-center text-muted">
                <i class="bi bi-music-note-beamed display-4 d-block mb-3 text-secondary"></i>
                <h5>No playlists found!</h5>
                <p>Try modifying your search criteria or create a brand new playlist.</p>
                <div class="mt-2">
                    <a href="{{ route('playlist.create') }}" class="btn btn-danger">Create Playlist Now</a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $playlists->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
