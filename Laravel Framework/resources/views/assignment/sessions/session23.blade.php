@extends('layouts.assignment')

@section('title', 'Session 23: Deployment Preparation')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 23</span> Deployment Preparation &amp; Environment Management</h2>
    <p class="text-muted">Production audit, environment variable security, permissions on <code>storage/</code> and <code>bootstrap/cache/</code>, and migration automation.</p>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-clipboard2-check text-primary me-2"></i> Deployment Readiness Audit
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Check Item</th>
                            <th>Current State</th>
                            <th>Production Target</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deploymentChecklist as $item => $data)
                            <tr>
                                <td class="fw-bold small">{{ $item }}</td>
                                <td><code>{{ $data['current'] }}</code></td>
                                <td class="small text-muted">{{ $data['recommended'] }}</td>
                                <td>
                                    @if($data['ok'])
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> OK</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> Local Only</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-cloud-upload text-success me-2"></i> Production Deployment Checklist
            </div>
            <div class="card-body">
                <ol class="small text-muted ps-3 mb-0">
                    <li class="mb-2"><strong>Turn off Debug Mode:</strong> Set <code>APP_DEBUG=false</code> in production <code>.env</code> to prevent leaking database credentials in error stacktraces.</li>
                    <li class="mb-2"><strong>Generate App Key:</strong> Run <code>php artisan key:generate --force</code>.</li>
                    <li class="mb-2"><strong>Migrate Database:</strong> Execute <code>php artisan migrate --force</code>.</li>
                    <li class="mb-2"><strong>Storage Symlink:</strong> Ensure <code>php artisan storage:link</code> has linked <code>storage/app/public</code> to <code>public/storage</code>.</li>
                    <li class="mb-2"><strong>File Permissions:</strong> Grant write permissions: <code>chmod -R 775 storage bootstrap/cache</code>.</li>
                    <li class="mb-2"><strong>Optimize Autoloader:</strong> <code>composer install --optimize-autoloader --no-dev</code>.</li>
                    <li><strong>Compile Caches:</strong> <code>php artisan optimize</code>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
