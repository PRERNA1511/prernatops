@extends('layouts.assignment')

@section('title', 'Session 17: Events, Listeners & Queues')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 17</span> Events, Listeners &amp; Background Queues</h2>
    <p class="text-muted">Decoupling application logic using event publishers, subscriber listeners, and offloading heavy tasks to asynchronous queue workers.</p>
</div>

<div class="row g-4">
    <!-- Trigger Event & Job -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-broadcast text-primary me-2"></i> Trigger Event &amp; Job Dispatch
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Clicking the button below dispatches the <code>PlaylistCreated</code> event, invokes <code>SendPlaylistCreatedNotification</code> listener, and queues the <code>ProcessAudioFile</code> background job:
                </p>
                <div class="p-2 border rounded bg-light mb-3 small">
                    <strong>Active Queue Driver:</strong> <code>{{ $queueDriver }}</code><br>
                    <strong>Registered Event:</strong> <code>App\Events\PlaylistCreated</code><br>
                    <strong>Registered Listener:</strong> <code>App\Listeners\SendPlaylistCreatedNotification</code><br>
                    <strong>Queued Job:</strong> <code>App\Jobs\ProcessAudioFile</code>
                </div>

                <form action="{{ route('session.17.trigger') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-play-circle-fill me-1"></i> Dispatch Event &amp; Queued Job
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Execution Logs -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-activity text-success me-2"></i> Event &amp; Job Execution Logs
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">Logs captured when event listeners and jobs are executed:</p>
                <pre class="code-block small" style="max-height: 250px;">{{ $recentLogs ?: 'No events dispatched yet. Click "Dispatch Event & Queued Job" to execute.' }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection
