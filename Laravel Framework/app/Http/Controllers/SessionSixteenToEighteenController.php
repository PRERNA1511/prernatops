<?php

namespace App\Http\Controllers;

use App\Events\PlaylistCreated;
use App\Jobs\ProcessAudioFile;
use App\Mail\WelcomeNotificationMail;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SessionSixteenToEighteenController extends Controller
{
    /**
     * Session 16: Mail Configuration, Mailable classes, Notifications.
     */
    public function session16()
    {
        $mailDriver = config('mail.default');
        $fromAddress = config('mail.from.address');
        $sampleUser = Auth::user() ?? User::first();

        // Read last 10 lines of laravel.log to see if emails were logged
        $logPath = storage_path('logs/laravel.log');
        $recentLogs = '';
        if (file_exists($logPath)) {
            $lines = file($logPath);
            $recentLogs = implode("", array_slice($lines, -15));
        }

        return view('assignment.sessions.session16', compact('mailDriver', 'fromAddress', 'sampleUser', 'recentLogs'));
    }

    /**
     * Send test mail via Mailable class (Session 16).
     */
    public function session16Send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'custom_message' => 'required|string|max:255',
        ]);

        $recipientEmail = $request->input('email');
        $customMessage = $request->input('custom_message');

        $user = User::where('email', $recipientEmail)->first() ?? new User([
            'name' => 'Demo Recipient',
            'email' => $recipientEmail,
        ]);

        // Send using Laravel Mailable
        Mail::to($recipientEmail)->send(new WelcomeNotificationMail($user, $customMessage));

        return redirect()->route('session.16')->with('success', "Email dispatched via Mail::to('{$recipientEmail}')->send()! Under the 'log' mailer driver, details are written to storage/logs/laravel.log.");
    }

    /**
     * Session 17: Events, Listeners, Queues, Background Jobs.
     */
    public function session17()
    {
        $queueDriver = config('queue.default');
        $latestPlaylist = Playlist::latest()->first();

        // Check recent logs for event/job dispatch notes
        $logPath = storage_path('logs/laravel.log');
        $recentLogs = '';
        if (file_exists($logPath)) {
            $lines = file($logPath);
            $recentLogs = implode("", array_slice($lines, -20));
        }

        return view('assignment.sessions.session17', compact('queueDriver', 'latestPlaylist', 'recentLogs'));
    }

    /**
     * Trigger Event & Queue Job (Session 17).
     */
    public function session17Trigger()
    {
        $playlist = Playlist::latest()->first() ?? Playlist::create([
            'user_id' => 1,
            'name' => 'Event Trigger Demo Playlist',
            'is_public' => true,
        ]);

        // 1. Dispatch Event
        event(new PlaylistCreated($playlist));

        // 2. Dispatch Background Job
        ProcessAudioFile::dispatch('audio/tracks/demo_track.mp3', 101);

        return redirect()->route('session.17')->with('success', "Event 'PlaylistCreated' fired & Background Job 'ProcessAudioFile' dispatched to queue ('{$playlist->name}')!");
    }

    /**
     * Session 18: Custom Middleware, Roles, CSRF, XSS Prevention.
     */
    public function session18()
    {
        $currentUser = Auth::user();
        return view('assignment.sessions.session18', compact('currentUser'));
    }

    /**
     * Protected Admin Action tested via CheckRoleMiddleware (Session 18).
     */
    public function session18AdminArea()
    {
        return view('assignment.sessions.session18_admin');
    }
}
