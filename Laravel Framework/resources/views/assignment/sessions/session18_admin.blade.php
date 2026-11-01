@extends('layouts.assignment')

@section('title', 'Admin Area - Session 18 Protected Route')

@section('content')
<div class="mb-4">
    <a href="{{ route('session.18') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Session 18
    </a>
    <div class="alert alert-success">
        <h4 class="alert-heading"><i class="bi bi-shield-lock-fill"></i> Access Granted!</h4>
        <p class="mb-0">You have successfully accessed the restricted Admin Area protected by <code>CheckRoleMiddleware (role:admin)</code>.</p>
    </div>
</div>

<div class="card">
    <div class="card-header bg-dark text-white fw-bold">
        Administrator Control Panel
    </div>
    <div class="card-body">
        <p>Authenticated as: <strong>{{ Auth::user()->name }}</strong> (<code>{{ Auth::user()->email }}</code>)</p>
        <p>Your current user account has the required <code>admin</code> role stored in the database.</p>
    </div>
</div>
@endsection
