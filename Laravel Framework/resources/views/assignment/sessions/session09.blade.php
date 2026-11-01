@extends('layouts.assignment')

@section('title', 'Session 9: Eloquent CRUD & Debugbar')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 09</span> Eloquent CRUD &amp; Debugbar Query Inspection</h2>
    <p class="text-muted">Performing Create, Read, Update, Delete with Eloquent ORM and analyzing SQL queries executed behind the scenes.</p>
</div>

<div class="row g-4">
    <!-- Eloquent Create Form -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-plus-circle text-success me-2"></i> Eloquent Create: Add Playlist
            </div>
            <div class="card-body">
                <form action="{{ route('session.09.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Playlist Name:</label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Chill Beats" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Genre:</label>
                        <select name="genre_id" class="form-select form-select-sm" required>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description:</label>
                        <textarea name="description" rows="2" class="form-control form-control-sm" placeholder="Short description..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-check-lg"></i> Save with Playlist::create()
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Eloquent Read & Delete List -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-journal-album text-primary me-2"></i> Eloquent Read &amp; Delete: Current Playlists
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Genre</th>
                                <th>Owner</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($playlists as $p)
                                <tr>
                                    <td class="fw-bold">{{ $p->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $p->genre ? $p->genre->name : 'Unassigned' }}</span></td>
                                    <td class="small text-muted">{{ $p->user ? $p->user->name : 'System' }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('session.09.delete', $p->id) }}" method="POST" onsubmit="return confirm('Delete playlist?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" title="Delete via Eloquent delete()">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No playlists found. Create one on the left!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Debugbar Query Analysis Demonstration -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-bug text-danger me-2"></i> Laravel Debugbar Queries Tab Demonstration
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    Laravel Debugbar captures every query executed during an HTTP request. Below is the captured query log showing the SQL statements, execution durations, and parameter bindings:
                </p>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 10%;">Duration</th>
                                <th>Executed SQL Query</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queryLogs as $log)
                                <tr>
                                    <td><span class="badge bg-info text-dark">{{ $log['time'] }} ms</span></td>
                                    <td><code>{{ $log['query'] }}</code></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
