@extends('layouts.assignment')

@section('title', 'Session 18: Middleware & Security')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 18</span> Middleware &amp; Security Protections</h2>
    <p class="text-muted">Custom role-checking middleware (<code>CheckRoleMiddleware</code>), CSRF protection, and automatic XSS prevention via Blade escaping.</p>
</div>

<div class="row g-4">
    <!-- Role Middleware Test -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-person-check text-primary me-2"></i> Role-Based Access Control (RBAC)
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    The route <code>/session-18/admin</code> is strictly protected by the custom <code>role:admin</code> middleware.
                </p>
                <div class="p-2 border rounded bg-light mb-3">
                    <strong>Your Current Status:</strong>
                    @if($currentUser)
                        <span class="badge bg-dark">{{ $currentUser->name }}</span>
                        Role: <span class="badge {{ $currentUser->isAdmin() ? 'bg-danger' : 'bg-primary' }}">{{ $currentUser->role }}</span>
                    @else
                        <span class="badge bg-secondary">Guest (Unauthenticated)</span>
                    @endif
                </div>

                <a href="{{ route('session.18.admin') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-lock-fill me-1"></i> Access Protected Admin Area (/session-18/admin)
                </a>
                <div class="form-text mt-1">If logged in as <code>student</code> (role: user), this triggers a 403 Forbidden abort.</div>
            </div>
        </div>
    </div>

    <!-- CSRF & XSS Explanations -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-shield-shaded text-success me-2"></i> CSRF &amp; XSS Prevention Architecture
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="fw-bold text-dark small mb-1">1. CSRF Token Protection</h6>
                    <p class="small text-muted mb-0">
                        Laravel generates a cryptographic CSRF token for each active session. Requests from external malicious domains are instantly rejected with HTTP 419 Page Expired.
                    </p>
                </div>
                <div>
                    <h6 class="fw-bold text-dark small mb-1">2. Automatic XSS Escaping</h6>
                    <p class="small text-muted mb-1">
                        Blade's <code>@{{ $data }}</code> syntax passes output through PHP's <code>htmlspecialchars()</code>, rendering malicious script tags harmless:
                    </p>
                    <div class="p-2 border rounded bg-light small">
                        <strong>Raw payload:</strong> <code>&lt;script&gt;alert('hacked');&lt;/script&gt;</code><br>
                        <strong>Blade output:</strong> {{ "<script>alert('hacked');</script>" }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
