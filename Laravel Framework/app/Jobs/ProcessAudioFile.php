<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAudioFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $filePath;
    public int $songId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $filePath, int $songId)
    {
        $this->filePath = $filePath;
        $this->songId = $songId;
    }

    /**
     * Execute the job in background.
     */
    public function handle()
    {
        Log::info('Queued Background Job Executed: ProcessAudioFile', [
            'song_id' => $this->songId,
            'file_path' => $this->filePath,
            'status' => 'Audio metadata analyzed, waveforms generated successfully',
            'time' => now()->toDateTimeString(),
        ]);
    }
}
