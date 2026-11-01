@extends('layouts.assignment')

@section('title', 'Session 13: Authentication Setup & Registration')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 13</span> Authentication &amp; User Registration</h2>
    <p class="text-muted">Implementing custom user registration with username, password hashing via <code>Hash::make()</code>, authentication guards, and route protection.</p>
</div>

<div class="row g-4">
    <!-- Registration Form -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-person-plus text-primary me-2"></i> Register New User (Custom Username Field)
            </div>
            <div class="card-body">
                <form action="{{ route('session.13.register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name:</label>
                        <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Unique Username:</label>
                        <input type="text" name="username" class="form-control form-control-sm @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="e.g. alex2026" required>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address:</label>
                        <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Password:</label>
                            <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Confirm Password:</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                        </div>
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-person-check-fill me-1"></i> Register &amp; Authenticate
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Auth State & Users -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-shield-lock text-success me-2"></i> Current Authentication State
            </div>
            <div class="card-body">
                @if($currentUser)
                    <div class="alert alert-success">
                        <div class="fw-bold"><i class="bi bi-check-circle"></i> Authenticated Session</div>
                        <div>Name: <strong>{{ $currentUser->name }}</strong></div>
                        <div>Username: <code>{{ $currentUser->username }}</code></div>
                        <div>Email: <code>{{ $currentUser->email }}</code></div>
                        <div>Role: <span class="badge bg-dark">{{ $currentUser->role }}</span></div>
                    </div>
                @else
                    <div class="alert alert-secondary">
                        <i class="bi bi-info-circle me-1"></i> Currently operating as a <strong>Guest</strong>.
                    </div>
                @endif

                <h6 class="fw-bold mt-3 mb-2">Registered Demo Accounts:</h6>
                <ul class="list-group list-group-flush border rounded">
                    @foreach($usersList as $u)
                        <li class="list-group-item d-flex justify-content-between align-items-center small py-2">
                            <div>
                                <strong>{{ $u->name }}</strong> ({{ $u->username }})<br>
                                <span class="text-muted">{{ $u->email }}</span>
                            </div>
                            <span class="badge bg-secondary">{{ $u->role }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
