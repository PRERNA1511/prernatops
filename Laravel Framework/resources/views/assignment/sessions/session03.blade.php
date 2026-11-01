@extends('layouts.assignment')

@section('title', 'Session 3: Controllers & Views')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 03</span> Controllers &amp; Views</h2>
    <p class="text-muted">Demonstrating controller action methods and passing scalar, array, and associative data to Blade views.</p>
</div>

<div class="row g-4">
    <!-- Primitive Data -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-card-text text-primary me-2"></i> Primitive Data Passed from Controller
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th class="bg-light" style="width: 40%;">Course Module:</th>
                        <td>{{ $courseModule }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Instructor Name:</th>
                        <td>{{ $instructorName }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Academic Semester:</th>
                        <td>Semester {{ $semester }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Associative Array -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-bar-chart text-success me-2"></i> Associative Array Data
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($courseStats as $label => $val)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $label }}:</span>
                            <span class="badge bg-primary rounded-pill">{{ $val }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Indexed Array Loop -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-list-check text-info me-2"></i> Syllabus Topics (Iterated with @foreach)
            </div>
            <div class="card-body">
                <ol class="mb-0">
                    @foreach($topicsCovered as $topic)
                        <li class="mb-1">{{ $topic }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
