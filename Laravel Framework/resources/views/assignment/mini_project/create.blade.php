@extends('layouts.assignment')

@section('title', 'Create Playlist - Mini Project')

@section('content')
<div class="mb-4">
    <a href="{{ route('playlist.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Playlists
    </a>
    <h2><i class="bi bi-plus-circle text-danger me-2"></i> Create New Music Playlist</h2>
    <p class="text-muted">Enter playlist details, select musical genre, upload cover artwork, and pick initial songs.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('playlist.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Playlist Title: <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Summer Roadtrip Vibes" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Music Genre: <span class="text-danger">*</span></label>
                    <select name="genre_id" class="form-select @error('genre_id') is-invalid @enderror" required>
                        <option value="">-- Choose Genre --</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description:</label>
                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Describe the vibe, theme, or mood of this playlist...">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Cover Image (Optional):</label>
                <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                <div class="form-text">Supported formats: JPG, JPEG, PNG, WEBP (Max: 2MB). Stored securely in public storage.</div>
                @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Add Songs to Playlist (Select Multiple):</label>
                <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                    @foreach($songs as $song)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="songs[]" value="{{ $song->id }}" id="song_{{ $song->id }}">
                            <label class="form-check-label d-flex justify-content-between pe-3" for="song_{{ $song->id }}">
                                <span><strong>{{ $song->title }}</strong> — {{ $song->artist }}</span>
                                <span class="text-muted small">{{ $song->formatted_duration }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('playlist.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-danger px-4">
                    <i class="bi bi-check-lg me-1"></i> Save &amp; Create Playlist
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
