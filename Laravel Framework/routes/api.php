<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlaylistApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Laravel Framework Assignment (Session 19 & 20)
|--------------------------------------------------------------------------
*/

// Session 19: RESTful Playlist API (CRUD endpoints)
Route::apiResource('playlists', PlaylistApiController::class);

// Session 20: Sanctum API Authentication & Token Management
Route::prefix('sanctum')->group(function () {
    // Public login endpoint to obtain Bearer token
    Route::post('/login', [AuthController::class, 'login'])->name('api.sanctum.login');

    // Protected endpoints requiring Bearer token + API request logging
    Route::middleware(['auth:sanctum', 'api.log'])->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('api.sanctum.user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.sanctum.logout');
    });
});
