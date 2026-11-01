@extends('layouts.assignment')

@section('title', 'Session 12: File Uploads & Storage')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 12</span> File Uploads &amp; Image Gallery</h2>
    <p class="text-muted">Handling multipart forms, validating image mimes &amp; sizes, generating unique filenames, storing in <code>storage/app/public</code>, and serving via symlink.</p>
</div>

<div class="row g-4">
    <!-- Upload Form -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-cloud-arrow-up text-primary me-2"></i> Upload Image to Public Storage
            </div>
            <div class="card-body">
                <form action="{{ route('session.12.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Image File (Max 2MB):</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        <div class="form-text">Supported formats: JPG, JPEG, PNG, WEBP.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Image Caption (Optional):</label>
                        <input type="text" name="caption" class="form-control" placeholder="e.g. Album Artwork">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload me-1"></i> Upload Image
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Gallery Display -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-images text-success me-2"></i> Uploaded Gallery (storage/app/public/gallery)</span>
                <span class="badge bg-secondary">{{ count($galleryImages) }} images</span>
            </div>
            <div class="card-body">
                @if(count($galleryImages) > 0)
                    <div class="row g-2">
                        @foreach($galleryImages as $img)
                            <div class="col-4">
                                <div class="border rounded p-1 text-center bg-light">
                                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded" style="height: 110px; width: 100%; object-fit: cover;" alt="Gallery">
                                    <div class="small text-truncate mt-1 text-muted">{{ basename($img) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-image display-5 d-block mb-2 text-secondary"></i>
                        No images uploaded yet. Upload an image using the form on the left!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
