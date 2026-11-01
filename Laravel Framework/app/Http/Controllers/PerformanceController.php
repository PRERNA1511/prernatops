<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    /**
     * Session 22: Configuration and route caching, query optimization, eager loading, and performance notes.
     */
    public function session22()
    {
        // 1. Column Selection Benchmark
        $timeStart = microtime(true);
        $fullColumns = Song::all();
        $fullTime = round((microtime(true) - $timeStart) * 1000, 3);

        $timeStart2 = microtime(true);
        $selectedColumns = Song::select('id', 'title', 'artist')->get();
        $selectedTime = round((microtime(true) - $timeStart2) * 1000, 3);

        // 2. Query Chunking simulation
        $chunkCount = 0;
        Song::chunk(4, function ($songs) use (&$chunkCount) {
            $chunkCount++;
        });

        // 3. Cache status
        $configCached = file_exists(base_path('bootstrap/cache/config.php'));
        $routesCached = file_exists(base_path('bootstrap/cache/routes-v7.php'));

        return view('assignment.sessions.session22', compact(
            'fullTime',
            'selectedTime',
            'chunkCount',
            'configCached',
            'routesCached'
        ));
    }

    /**
     * Session 23: Environment management, migrations, deployment preparation, and production debug settings.
     */
    public function session23()
    {
        $appEnv = config('app.env');
        $appDebug = config('app.debug');
        $appUrl = config('app.url');

        $storageWritable = is_writable(storage_path());
        $bootstrapCacheWritable = is_writable(base_path('bootstrap/cache'));

        $deploymentChecklist = [
            'Environment (APP_ENV)' => [
                'current' => $appEnv,
                'recommended' => 'production',
                'ok' => $appEnv === 'production',
            ],
            'Debug Mode (APP_DEBUG)' => [
                'current' => $appDebug ? 'true (ENABLED)' : 'false (DISABLED)',
                'recommended' => 'false',
                'ok' => !$appDebug,
            ],
            'Storage Directory Writable' => [
                'current' => $storageWritable ? 'Writable' : 'Not Writable',
                'recommended' => 'Writable (chmod 775)',
                'ok' => $storageWritable,
            ],
            'Bootstrap Cache Writable' => [
                'current' => $bootstrapCacheWritable ? 'Writable' : 'Not Writable',
                'recommended' => 'Writable (chmod 775)',
                'ok' => $bootstrapCacheWritable,
            ],
            'App Key Generated' => [
                'current' => !empty(config('app.key')) ? 'Configured' : 'Missing',
                'recommended' => '32-character base64 key',
                'ok' => !empty(config('app.key')),
            ],
        ];

        return view('assignment.sessions.session23', compact('deploymentChecklist'));
    }
}
