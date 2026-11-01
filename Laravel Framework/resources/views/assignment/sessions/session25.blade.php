@extends('layouts.assignment')

@section('title', 'Session 25: Code Review & Documentation')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 25</span> Code Review, PHPDoc &amp; Version Tracking</h2>
    <p class="text-muted">Code review evaluation, adherence to PSR standards, PHPDoc annotation verification, Git commits, and documentation index.</p>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-check2-all text-success me-2"></i> Quality Assurance &amp; Code Review Checklist
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Evaluation Criterion</th>
                            <th>Status</th>
                            <th>Review Findings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($codeReviewChecklist as $crit => $row)
                            <tr>
                                <td class="fw-bold small">{{ $crit }}</td>
                                <td><span class="badge bg-success">{{ $row['status'] }}</span></td>
                                <td class="small text-muted">{{ $row['notes'] }}</td>
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
                <i class="bi bi-git text-danger me-2"></i> Version Tracking &amp; Repository Overview
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    @foreach($gitSummary as $key => $val)
                        <li class="list-group-item d-flex justify-content-between align-items-center small py-2">
                            <strong>{{ $key }}:</strong>
                            <span class="text-muted text-end">{{ $val }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="border rounded p-2 bg-light small">
                    <strong>Assignment Directory Structure:</strong><br>
                    Documentation and task notes are permanently archived inside the <code>Laravel_Assignment/</code> directory with 25 dedicated sub-folders (<code>Session_01_Introduction</code> to <code>Session_25_Code_Review_Documentation</code>).
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
