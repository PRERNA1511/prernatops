@extends('layouts.assignment')

@section('title', 'Session 11: Form Request Validation')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 11</span> Form Request Validation &amp; Custom Messages</h2>
    <p class="text-muted">Extracting validation logic into dedicated Form Request class (<code>StorePlaylistRequest</code>), authorizing requests, and rendering custom error alerts.</p>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-shield-check text-primary me-2"></i> Form Request Validation Form
            </div>
            <div class="card-body">
                <form action="{{ route('session.11.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Playlist Title:</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Minimum 3 characters">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Genre:</label>
                        <select name="genre_id" class="form-select @error('genre_id') is-invalid @enderror">
                            <option value="">-- Choose Genre --</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('genre_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description (Optional):</label>
                        <textarea name="description" rows="2" class="form-control @error('description') is-invalid @enderror" placeholder="Add description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle me-1"></i> Submit with StorePlaylistRequest
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-code-slash text-success me-2"></i> Form Request Architecture
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Generated via <code>php artisan make:request StorePlaylistRequest</code>:
                </p>
                <div class="code-block small mb-3">
class StorePlaylistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Authorization check
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100',
            'genre_id' => 'required|exists:genres,id',
        ];
    }
}
                </div>
                <div class="small text-muted">
                    <strong>Benefit:</strong> Controllers remain slim and focused only on application orchestration, keeping validation rules reusable and easy to unit test.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
