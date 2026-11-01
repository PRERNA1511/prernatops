@extends('layouts.assignment')

@section('title', 'Session 5: Request Handling & Validation')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 05</span> Request Handling &amp; Form Validation</h2>
    <p class="text-muted">Demonstrating CSRF protection with <code>@csrf</code>, request parameter inspection, inline validation, and session flash alerts.</p>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-ui-checks text-primary me-2"></i> Student Feedback Form (With Validation)
            </div>
            <div class="card-body">
                <form action="{{ route('session.05.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Student Name:</label>
                        <input type="text" name="student_name" class="form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name') }}" placeholder="e.g. John Doe">
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address:</label>
                        <input type="email" name="student_email" class="form-control @error('student_email') is-invalid @enderror" value="{{ old('student_email') }}" placeholder="john@example.com">
                        @error('student_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Feedback (min 10 characters):</label>
                        <textarea name="feedback" rows="3" class="form-control @error('feedback') is-invalid @enderror" placeholder="Write feedback regarding the Laravel framework lectures...">{{ old('feedback') }}</textarea>
                        @error('feedback')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill me-1"></i> Submit Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-shield-lock text-success me-2"></i> CSRF &amp; Request Lifecycle Notes
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong class="text-dark">What is @csrf?</strong>
                    <p class="small text-muted mb-0">
                        The <code>@csrf</code> Blade directive automatically injects a hidden <code>_token</code> input field containing a secret session token that Laravel verifies on every POST/PUT/DELETE request to prevent Cross-Site Request Forgery attacks.
                    </p>
                </div>
                <div class="mb-3">
                    <strong class="text-dark">Controller Validation:</strong>
                    <div class="code-block small">
$validated = $request->validate([
    'student_name'  => 'required|min:3',
    'student_email' => 'required|email',
    'feedback'      => 'required|min:10',
]);
                    </div>
                </div>
                <div>
                    <strong class="text-dark">Old Input Repopulation:</strong>
                    <p class="small text-muted mb-0">
                        When validation fails, Laravel redirects back with error messages and flashes the user's previous input so that fields are repopulated using <code>old('field_name')</code>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
