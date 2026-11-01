@extends('layouts.assignment')

@section('title', 'Session 4: Blade Templating Engine')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 04</span> Blade Templating Engine</h2>
    <p class="text-muted">Directives, conditional statements (<code>@if</code>, <code>@unless</code>), loops (<code>@foreach</code>, <code>@forelse</code>), loop variables, and template inheritance.</p>
</div>

<div class="row g-4">
    <!-- Conditionals -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-question-diamond text-primary me-2"></i> Blade Conditional Directives
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>1. Authentication Status Check (@if / @else):</strong>
                    <div class="mt-1">
                        @if($isLoggedIn)
                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> User is Logged In</span>
                        @else
                            <span class="badge bg-danger">User is Guest</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <strong>2. Role Multi-branch (@if / @elseif / @else):</strong>
                    <div class="mt-1">
                        @if($userRole === 'admin')
                            <span class="badge bg-danger">Administrator Privilege</span>
                        @elseif($userRole === 'editor')
                            <span class="badge bg-warning text-dark"><i class="bi bi-pencil"></i> Editor Privilege</span>
                        @else
                            <span class="badge bg-secondary">Standard Reader</span>
                        @endif
                    </div>
                </div>

                <div>
                    <strong>3. Score Evaluation:</strong>
                    <div class="mt-1">
                        @if($score >= 90)
                            <span class="text-success fw-bold">Grade A (Outstanding)</span>
                        @elseif($score >= 75)
                            <span class="text-primary fw-bold">Grade B (Good Performance: {{ $score }}%)</span>
                        @else
                            <span class="text-danger fw-bold">Needs Improvement</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loop Variable Demo -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-arrow-repeat text-success me-2"></i> Loop Variables in @foreach
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Topic</th>
                            <th>Status</th>
                            <th>Loop Flags</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['title'] }}</td>
                                <td>
                                    <span class="badge {{ $item['status'] == 'Done' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($loop->first)
                                        <span class="badge bg-info text-dark">First</span>
                                    @endif
                                    @if($loop->last)
                                        <span class="badge bg-dark">Last</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- @forelse & @empty -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-inbox text-warning me-2"></i> Handling Empty Collections with @forelse &amp; @empty
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($emptyList as $val)
                        <li class="list-group-item">{{ $val }}</li>
                    @empty
                        <li class="list-group-item text-muted text-center py-3">
                            <i class="bi bi-folder2-open display-6 d-block mb-2 text-secondary"></i>
                            No items found in this list. Rendered gracefully via <code>@forelse ... @empty ... @endforelse</code> directive.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
