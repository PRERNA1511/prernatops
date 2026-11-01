@extends('layouts.assignment')

@section('title', 'Session 1: Introduction to Laravel & MVC')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <div class="d-flex align-items-center justify-content-between">
        <h2><span class="badge bg-secondary me-2">Session 01</span> Introduction to Laravel Framework</h2>
        <span class="badge bg-success">Status: Completed</span>
    </div>
    <p class="text-muted">Overview of the Laravel ecosystem, system requirements, MVC pattern, directory structure, and Artisan CLI.</p>
</div>

<div class="row g-4">
    <!-- Environment Verification -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-gear-wide-connected text-primary me-2"></i> Environment Status
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>PHP Version:</span>
                        <strong class="text-success">{{ $phpVersion }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Laravel Framework Version:</span>
                        <strong class="text-primary">{{ $laravelVersion }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Application Environment:</span>
                        <span class="badge bg-info">{{ config('app.env') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Debug Mode:</span>
                        <span class="badge {{ config('app.debug') ? 'bg-warning text-dark' : 'bg-secondary' }}">
                            {{ config('app.debug') ? 'Enabled (Local)' : 'Disabled' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- MVC Architecture -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-diagram-3 text-danger me-2"></i> MVC Architecture
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">Laravel adheres strictly to Model-View-Controller architectural separation:</p>
                <div class="border rounded p-2 mb-2 bg-light">
                    <strong class="text-primary">Model (app/Models):</strong> Handles database interactions, relationships, and business domain logic.
                </div>
                <div class="border rounded p-2 mb-2 bg-light">
                    <strong class="text-danger">View (resources/views):</strong> Blade templates rendering responsive HTML and UI elements for end-users.
                </div>
                <div class="border rounded p-2 bg-light">
                    <strong class="text-success">Controller (app/Http/Controllers):</strong> Coordinates incoming HTTP requests, invokes models, and delivers view responses.
                </div>
            </div>
        </div>
    </div>

    <!-- Key Artisan Commands -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-terminal text-dark me-2"></i> Artisan CLI Commands Overview
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 35%;">Artisan Command</th>
                                <th>Description / Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artisanCommands as $cmd => $desc)
                                <tr>
                                    <td><code>{{ $cmd }}</code></td>
                                    <td>{{ $desc }}</td>
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
