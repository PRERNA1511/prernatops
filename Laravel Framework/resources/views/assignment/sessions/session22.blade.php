@extends('layouts.assignment')

@section('title', 'Session 22: Performance Optimization')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 22</span> Performance Optimization &amp; Caching</h2>
    <p class="text-muted">Route caching, configuration caching, query column selection, chunking, and database indexing.</p>
</div>

<div class="row g-4">
    <!-- Caching Status -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-lightning text-warning me-2"></i> Production Caching Commands
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Config Cache (<code>config:cache</code>):</span>
                        <span class="badge {{ $configCached ? 'bg-success' : 'bg-secondary' }}">
                            {{ $configCached ? 'Cached' : 'Not Cached (Development Mode)' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Route Cache (<code>route:cache</code>):</span>
                        <span class="badge {{ $routesCached ? 'bg-success' : 'bg-secondary' }}">
                            {{ $routesCached ? 'Cached' : 'Not Cached (Development Mode)' }}
                        </span>
                    </li>
                </ul>

                <div class="border rounded p-2 bg-light small">
                    <strong>Artisan Optimization Commands:</strong><br>
                    <code>php artisan config:cache</code> - Combines all config files into a single array.<br>
                    <code>php artisan route:cache</code> - Drastically speeds up route matching.<br>
                    <code>php artisan view:cache</code> - Pre-compiles Blade templates to raw PHP.<br>
                    <code>php artisan optimize:clear</code> - Clears all caches during development.
                </div>
            </div>
        </div>
    </div>

    <!-- Query Optimization Benchmark -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-speedometer2 text-primary me-2"></i> Query Optimization Benchmark
            </div>
            <div class="card-body">
                <h6 class="fw-bold small text-muted mb-2">1. Specific Column Selection:</h6>
                <div class="p-2 border rounded bg-light mb-3 small">
                    <div><strong>Song::all() (All Columns):</strong> <code>{{ $fullTime }} ms</code></div>
                    <div><strong>Song::select('id','title','artist') (Specific Columns):</strong> <code>{{ $selectedTime }} ms</code></div>
                    <div class="text-muted mt-1">Selecting only necessary columns reduces memory usage and serialization overhead.</div>
                </div>

                <h6 class="fw-bold small text-muted mb-2">2. Chunking Large Datasets:</h6>
                <div class="p-2 border rounded bg-light small">
                    <div><code>Song::chunk(4, callback)</code> processed songs in <strong>{{ $chunkCount }}</strong> separate batches.</div>
                    <div class="text-muted mt-1">Prevents PHP memory exhaustion when handling tens of thousands of rows.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
