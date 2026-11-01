@extends('layouts.assignment')

@section('title', 'Edit Playlist - ' . $playlist->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('playlist.show', $playlist->id) }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Playlist
    </a>
    <h2><i class="bi bi-pencil-square text-primary me-2"></i> Edit Playlist: {{ $playlist->name }}</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('playlist.update', $playlist->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Playlist Title:</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $playlist->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Music Genre:</label>
                    <select name="genre_id" class="form-select @error('genre_id') is-invalid @enderror" required>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id', $playlist->genre_id) == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description:</label>
                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $playlist->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Replace Cover Image (Optional):</label>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <img src="{{ $playlist->cover_url }}" alt="Current Cover" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                </div>
                @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('playlist.show', $playlist->id) }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Update Playlist
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
