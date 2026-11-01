@extends('layouts.assignment')

@section('title', 'Assignment Dashboard - Sessions 1 to 25')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h1 class="h3 fw-bold mb-1 text-dark">
            <i class="bi bi-mortarboard-fill text-danger me-2"></i> Laravel Framework Complete Assignment
        </h1>
        <p class="text-muted mb-0">
            All 25 sessions implemented with clean, beginner-friendly code, practical task demonstrations, and a full-stack Playlist Mini Project.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('playlist.index') }}" class="btn btn-danger btn-lg shadow-sm">
            <i class="bi bi-play-circle-fill me-2"></i> Launch Mini Project (S24)
        </a>
    </div>
</div>

<!-- Quick Stats Summary -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 bg-white text-center">
            <div class="h4 fw-bold text-primary mb-0">25 / 25</div>
            <div class="text-muted small">Sessions Completed</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 bg-white text-center">
            <div class="h4 fw-bold text-success mb-0">{{ \App\Models\Playlist::count() }}</div>
            <div class="text-muted small">Database Playlists</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 bg-white text-center">
            <div class="h4 fw-bold text-warning mb-0">{{ \App\Models\Song::count() }}</div>
            <div class="text-muted small">Available Songs</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 bg-white text-center">
            <div class="h4 fw-bold text-info mb-0">v{{ app()->version() }}</div>
            <div class="text-muted small">Laravel Framework</div>
        </div>
    </div>
</div>

<!-- Sessions 1 to 25 Grid -->
<div class="row g-3">
    @foreach($sessions as $num => $sess)
        <div class="col-md-6 col-lg-4" id="session-{{ $num }}">
            <div class="card h-100 {{ $num == 24 ? 'border-danger border-2' : '' }}">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                    <span class="badge bg-secondary badge-session">Session {{ sprintf('%02d', $num) }}</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i class="bi bi-check2-circle"></i> {{ $sess['status'] }}
                    </span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title h6 fw-bold mb-2">
                        @if($num == 24)
                            <i class="bi bi-star-fill text-danger me-1"></i>
                        @endif
                        {{ $sess['title'] }}
                    </h5>
                    <p class="card-text text-muted small flex-grow-1">
                        {{ $sess['desc'] }}
                    </p>
                    <div class="mt-2 pt-2 border-top">
                        @if(Route::has($sess['route']))
                            <a href="{{ route($sess['route']) }}" class="btn btn-sm {{ $num == 24 ? 'btn-danger w-100 fw-bold' : 'btn-outline-primary w-100' }}">
                                Open Session {{ $num }} Demo <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        @else
                            <a href="{{ url('/api/playlists') }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
                                View JSON Endpoint <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
