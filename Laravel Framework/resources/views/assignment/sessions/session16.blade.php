@extends('layouts.assignment')

@section('title', 'Session 16: Mail & Notifications')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 16</span> Mail Configuration &amp; Mailable Classes</h2>
    <p class="text-muted">Setting up email delivery drivers, building responsive Blade email templates, and dispatching Mailable instances via <code>Mail::to()->send()</code>.</p>
</div>

<div class="row g-4">
    <!-- Send Email Form -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-envelope-at text-primary me-2"></i> Send Notification Email
            </div>
            <div class="card-body">
                <form action="{{ route('session.16.send') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Recipient Email:</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ $sampleUser->email ?? 'student@example.com' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Custom Notification Message:</label>
                        <input type="text" name="custom_message" class="form-control form-control-sm" value="Congratulations on reaching Session 16 of the Laravel assignment!" required>
                    </div>

                    <div class="alert alert-info small py-2 mb-3">
                        <i class="bi bi-info-circle me-1"></i> <strong>Active Mailer Driver:</strong> <code>{{ $mailDriver }}</code> (writes safely to local log file without requiring third-party credentials).
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-send-fill me-1"></i> Dispatch Mailable
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mail Logs Viewer -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-journal-text text-success me-2"></i> Mail Log Stream (storage/logs/laravel.log)
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    In development mode (<code>MAIL_MAILER=log</code>), Laravel dumps the rendered email body and RFC-compliant headers directly into the log:
                </p>
                <pre class="code-block small" style="max-height: 250px;">{{ $recentLogs ?: 'No emails logged yet. Click "Dispatch Mailable" on the left to test!' }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection
