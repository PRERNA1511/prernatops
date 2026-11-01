@extends('layouts.assignment')

@section('title', 'Session 6: Database Configuration')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 06</span> Database Configuration &amp; .env</h2>
    <p class="text-muted">Configuring MySQL and SQLite database connections, managing environment variables, and checking connection health.</p>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-database-check text-primary me-2"></i> Current Connection Status
            </div>
            <div class="card-body">
                <div class="alert {{ $isConnected ? 'alert-success' : 'alert-danger' }} d-flex align-items-center">
                    <i class="bi {{ $isConnected ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} fs-3 me-3"></i>
                    <div>
                        <div class="fw-bold">{{ $isConnected ? 'Connected Successfully' : 'Connection Error' }}</div>
                        <div class="small">{{ $connectionMessage }}</div>
                    </div>
                </div>

                <table class="table table-bordered mb-0">
                    <tr>
                        <th class="bg-light" style="width: 45%;">Default Driver:</th>
                        <td><span class="badge bg-dark">{{ $dbConnection }}</span></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Database Host:</th>
                        <td>{{ $dbHost }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Active Database:</th>
                        <td><code>{{ $dbDatabase }}</code></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-file-earmark-code text-info me-2"></i> MySQL Configuration in .env
            </div>
            <div class="card-body">
                <p class="small text-muted">To configure MySQL locally in WAMP / XAMPP, set the following keys in your <code>.env</code> file:</p>
                <div class="code-block mb-3">
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_assignment
DB_USERNAME=root
DB_PASSWORD=
                </div>
                <div class="small text-muted">
                    <strong>Note:</strong> SQLite is currently active for zero-configuration local execution and testing. To switch to MySQL, update <code>.env</code> and run <code>php artisan migrate</code>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
