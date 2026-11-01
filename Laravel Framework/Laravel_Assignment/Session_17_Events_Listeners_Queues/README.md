# Session 17: Events, Listeners & Background Queues

## Session Overview
Session 17 demonstrates the Observer / Event-Driven architecture in Laravel, creating Events (`PlaylistCreated`), attaching asynchronous Listeners (`SendPlaylistCreatedNotification`), and creating background queued jobs (`ProcessAudioFile`).

---

## Practical Tasks & Implementation

### Task 1: Creating Events & Listeners
- Generated `app/Events/PlaylistCreated.php` via `php artisan make:event PlaylistCreated`.
- Generated `app/Listeners/SendPlaylistCreatedNotification.php` via `php artisan make:listener SendPlaylistCreatedNotification`.
- Registered mapping in `app/Providers/EventServiceProvider.php`.

### Task 2: Background Queued Jobs
- Created `app/Jobs/ProcessAudioFile.php` implementing `ShouldQueue`.
- Dispatches via `ProcessAudioFile::dispatch('audio/tracks/demo.mp3', 101)`.
- Queues offload time-consuming tasks (e.g. audio compression, metadata tagging) to keep user responses fast.

### Task 3: Dispatch & Execution Verification
- Dispatched event and job from `SessionSixteenToEighteenController::session17Trigger()`, writing execution metadata into the log.

---

## Files Created & Referenced
- `app/Events/PlaylistCreated.php`
- `app/Listeners/SendPlaylistCreatedNotification.php`
- `app/Jobs/ProcessAudioFile.php`
- `app/Providers/EventServiceProvider.php`
- `app/Http/Controllers/SessionSixteenToEighteenController.php` (`session17`, `session17Trigger`)
- `resources/views/assignment/sessions/session17.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-17`.
2. Click "Dispatch Event & Queued Job".
3. Check the execution logs displayed on the right showing the event trigger and job execution timestamps.
