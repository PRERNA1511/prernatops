<?php
// Session 2 Routing Reference Code

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionOneToFiveController;

// 1. Basic Route
Route::get('/welcome', function () {
    return 'Welcome to Laravel Routing!';
});

// 2. Route Parameter with Numeric Constraint
Route::get('/user/{id}', [SessionOneToFiveController::class, 'session2UserParam'])
    ->whereNumber('id')
    ->name('user.profile');

// 3. Named Route with Regular Expression Alpha Constraint
Route::get('/category/{slug}', function ($slug) {
    return "Category: " . htmlspecialchars($slug);
})->whereAlpha('slug')->name('category.show');

// 4. Route Group with Prefix
Route::prefix('session-02')->group(function () {
    Route::get('/', [SessionOneToFiveController::class, 'session2'])->name('session.02');
    Route::post('/post-demo', [SessionOneToFiveController::class, 'session2Post'])->name('session.02.post');
});
