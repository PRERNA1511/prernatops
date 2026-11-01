@extends('layouts.assignment')

@section('title', 'Session 2: Routing & Parameters')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 02</span> Routing &amp; Parameters</h2>
    <p class="text-muted">Defining GET and POST routes, route parameters, regular expression constraints, named routes, and route groups in <code>routes/web.php</code>.</p>
</div>

@if($submittedData)
    <div class="alert alert-primary alert-dismissible fade show">
        <i class="bi bi-info-circle-fill me-2"></i> <strong>Route Output:</strong> {{ $submittedData }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Test 1: Route Parameters with Numeric Constraint -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-link-45deg text-primary me-2"></i> Route Parameters &amp; Constraints
            </div>
            <div class="card-body">
                <p class="small text-muted">Test a route with a numeric parameter and <code>whereNumber('id')</code> constraint:</p>
                <div class="code-block mb-3">
Route::get('/session-02/user/{id}', [Controller::class, 'user'])
    ->whereNumber('id')
    ->name('session.02.user');
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('session.02.user', ['id' => 42]) }}" class="btn btn-outline-primary btn-sm">
                        Test User ID: 42
                    </a>
                    <a href="{{ route('session.02.user', ['id' => 108]) }}" class="btn btn-outline-primary btn-sm">
                        Test User ID: 108
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Test 2: POST Route with Form Submission -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-send text-success me-2"></i> POST Route Form Test
            </div>
            <div class="card-body">
                <p class="small text-muted">Submitting this form invokes a registered POST route protected by <code>@csrf</code>:</p>
                <form action="{{ route('session.02.post') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Full Name:</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="Student Developer" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Assigned Role:</label>
                        <select name="role" class="form-select form-select-sm">
                            <option value="Student">Student</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Evaluator">Evaluator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-lg"></i> Send POST Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Route Groups Explanation -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-collection text-warning me-2"></i> Route Groups &amp; Named Routes
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Route groups allow sharing common attributes like URL prefixes, middleware, and namespaces across multiple routes without duplicating code.
                </p>
                <div class="code-block">
// routes/web.php route group example:
Route::prefix('session-02')->group(function () {
    Route::get('/', [SessionOneToFiveController::class, 'session2'])->name('session.02');
    Route::get('/user/{id}', [SessionOneToFiveController::class, 'session2UserParam'])->whereNumber('id');
    Route::post('/post-demo', [SessionOneToFiveController::class, 'session2Post'])->name('session.02.post');
});
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
