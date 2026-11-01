@extends('layouts.assignment')

@section('title', 'Session 7: Migrations & Schema')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 07</span> Migrations &amp; Schema Management</h2>
    <p class="text-muted">Designing database schemas with Blueprint, creating foreign keys, and managing rollbacks.</p>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-table text-primary me-2"></i> Migrated Database Tables
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Table Name</th>
                                <th>Schema Role &amp; Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tables as $tbl => $purpose)
                                <tr>
                                    <td><code>{{ $tbl }}</code></td>
                                    <td class="small">{{ $purpose }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-arrow-counterclockwise text-danger me-2"></i> Migration &amp; Rollback Commands
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">Artisan migration commands used for version-controlling database schemas:</p>
                <div class="border rounded p-2 mb-2 bg-light">
                    <code>php artisan migrate</code>
                    <div class="small text-muted">Runs all new pending migration files.</div>
                </div>
                <div class="border rounded p-2 mb-2 bg-light">
                    <code>php artisan migrate:rollback</code>
                    <div class="small text-muted">Rolls back the last executed migration batch.</div>
                </div>
                <div class="border rounded p-2 mb-2 bg-light">
                    <code>php artisan migrate:reset</code>
                    <div class="small text-muted">Rolls back all migrations across the entire database.</div>
                </div>
                <div class="border rounded p-2 bg-light">
                    <code>php artisan migrate:refresh --seed</code>
                    <div class="small text-muted">Rolls back all migrations, re-runs them, and seeds sample data.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
