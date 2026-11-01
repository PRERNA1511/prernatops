<?php

namespace App\Listeners;

use App\Events\PlaylistCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPlaylistCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(PlaylistCreated $event)
    {
        Log::info('Event Listener Executed: PlaylistCreated', [
            'playlist_id' => $event->playlist->id,
            'playlist_name' => $event->playlist->name,
            'user_id' => $event->playlist->user_id,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
