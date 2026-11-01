<?php

use App\Http\Controllers\AjaxSongController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PlaylistProjectController;
use App\Http\Controllers\Session25Controller;
use App\Http\Controllers\SessionElevenToFifteenController;
use App\Http\Controllers\SessionOneToFiveController;
use App\Http\Controllers\SessionSixteenToEighteenController;
use App\Http\Controllers\SessionSixToTenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Laravel Framework Assignment (Session 1 to 25)
|--------------------------------------------------------------------------
*/

// Master Assignment Dashboard
Route::get('/', [AssignmentController::class, 'index'])->name('assignment.home');
Route::get('/assignment', [AssignmentController::class, 'index'])->name('assignment.dashboard');

// Session 1: Introduction to Laravel & MVC
Route::get('/session-01', [SessionOneToFiveController::class, 'session1'])->name('session.01');

// Session 2: Routing, Parameters, Constraints, Named Routes, Groups, GET & POST
Route::prefix('session-02')->group(function () {
    Route::get('/', [SessionOneToFiveController::class, 'session2'])->name('session.02');
    Route::get('/user/{id}', [SessionOneToFiveController::class, 'session2UserParam'])->whereNumber('id')->name('session.02.user');
    Route::post('/post-demo', [SessionOneToFiveController::class, 'session2Post'])->name('session.02.post');
});

// Session 3: Controllers and Passing Data to Blade Views
Route::get('/session-03', [SessionOneToFiveController::class, 'session3'])->name('session.03');

// Session 4: Blade Syntax, Loops, Conditions, Inheritance
Route::get('/session-04', [SessionOneToFiveController::class, 'session4'])->name('session.04');

// Session 5: Request Handling, Forms, CSRF, Validation, Flash Alerts
Route::get('/session-05', [SessionOneToFiveController::class, 'session5'])->name('session.05');
Route::post('/session-05/submit', [SessionOneToFiveController::class, 'session5Submit'])->name('session.05.submit');

// Session 6: MySQL Database Configuration & .env
Route::get('/session-06', [SessionSixToTenController::class, 'session6'])->name('session.06');

// Session 7: Migrations, Schema Changes, Rollback
Route::get('/session-07', [SessionSixToTenController::class, 'session7'])->name('session.07');

// Session 8: Factories, Faker, Seeders, Sample Data
Route::get('/session-08', [SessionSixToTenController::class, 'session8'])->name('session.08');

// Session 9: Eloquent CRUD & Debugbar Query Analysis
Route::get('/session-09', [SessionSixToTenController::class, 'session9'])->name('session.09');
Route::post('/session-09/store', [SessionSixToTenController::class, 'session9Store'])->name('session.09.store');
Route::delete('/session-09/delete/{id}', [SessionSixToTenController::class, 'session9Delete'])->name('session.09.delete');

// Session 10: One-to-One, One-to-Many, Many-to-Many, Eager vs Lazy Loading
Route::get('/session-10', [SessionSixToTenController::class, 'session10'])->name('session.10');

// Session 11: Validation Rules, Custom Messages, Form Requests
Route::get('/session-11', [SessionElevenToFifteenController::class, 'session11'])->name('session.11');
Route::post('/session-11/store', [SessionElevenToFifteenController::class, 'session11Store'])->name('session.11.store');

// Session 12: File Uploads, Validation, Storage Disk, Image Gallery
Route::get('/session-12', [SessionElevenToFifteenController::class, 'session12'])->name('session.12');
Route::post('/session-12/upload', [SessionElevenToFifteenController::class, 'session12Upload'])->name('session.12.upload');

// Session 13: Authentication Setup, Custom Registration (username), Protected Routes
Route::get('/session-13', [SessionElevenToFifteenController::class, 'session13'])->name('session.13');
Route::post('/session-13/register', [SessionElevenToFifteenController::class, 'session13Register'])->name('session.13.register');

// Session 14: Login Customization (username/email), Logout, Wishlist Protection
Route::get('/session-14', [SessionElevenToFifteenController::class, 'session14'])->name('session.14');
Route::post('/session-14/login', [SessionElevenToFifteenController::class, 'session14Login'])->name('session.14.login');
Route::post('/session-14/logout', [SessionElevenToFifteenController::class, 'session14Logout'])->name('session.14.logout');
Route::post('/session-14/wishlist/{id}', [SessionElevenToFifteenController::class, 'session14ToggleWishlist'])->name('session.14.wishlist');

// Session 15: Query Scopes, Accessors, Mutators, Query Builder, Raw SQL
Route::get('/session-15', [SessionElevenToFifteenController::class, 'session15'])->name('session.15');

// Session 16: Mail Configuration, Mailable Classes, Notifications
Route::get('/session-16', [SessionSixteenToEighteenController::class, 'session16'])->name('session.16');
Route::post('/session-16/send', [SessionSixteenToEighteenController::class, 'session16Send'])->name('session.16.send');

// Session 17: Events, Listeners, Queues, Background Jobs
Route::get('/session-17', [SessionSixteenToEighteenController::class, 'session17'])->name('session.17');
Route::post('/session-17/trigger', [SessionSixteenToEighteenController::class, 'session17Trigger'])->name('session.17.trigger');

// Session 18: Middleware, Roles, CSRF, XSS Prevention
Route::get('/session-18', [SessionSixteenToEighteenController::class, 'session18'])->name('session.18');
Route::get('/session-18/admin', [SessionSixteenToEighteenController::class, 'session18AdminArea'])->middleware('role:admin')->name('session.18.admin');

// Session 21: jQuery AJAX Frontend & Dynamic Song Search
Route::get('/session-21', [AjaxSongController::class, 'index'])->name('session.21');
Route::get('/session-21/search', [AjaxSongController::class, 'search'])->name('session.21.search');

// Session 22: Performance Optimization & Caching
Route::get('/session-22', [PerformanceController::class, 'session22'])->name('session.22');

// Session 23: Deployment Readiness & Environment Audit
Route::get('/session-23', [PerformanceController::class, 'session23'])->name('session.23');

// Session 24: Playlist Mini Project (Full CRUD, Cover Images, Songs, Likes)
Route::prefix('mini-project')->group(function () {
    Route::get('/playlists', [PlaylistProjectController::class, 'index'])->name('playlist.index');
    Route::get('/playlists/create', [PlaylistProjectController::class, 'create'])->name('playlist.create');
    Route::post('/playlists', [PlaylistProjectController::class, 'store'])->name('playlist.store');
    Route::get('/playlists/{id}', [PlaylistProjectController::class, 'show'])->name('playlist.show');
    Route::get('/playlists/{id}/edit', [PlaylistProjectController::class, 'edit'])->name('playlist.edit');
    Route::put('/playlists/{id}', [PlaylistProjectController::class, 'update'])->name('playlist.update');
    Route::delete('/playlists/{id}', [PlaylistProjectController::class, 'destroy'])->name('playlist.destroy');
    Route::post('/playlists/{id}/songs', [PlaylistProjectController::class, 'addSong'])->name('playlist.addSong');
    Route::delete('/playlists/{id}/songs/{songId}', [PlaylistProjectController::class, 'removeSong'])->name('playlist.removeSong');
    Route::post('/playlists/{id}/like', [PlaylistProjectController::class, 'toggleLike'])->name('playlist.like');
});

// Session 25: Code Review, README, PHPDoc, Git, Version Tracking
Route::get('/session-25', [Session25Controller::class, 'index'])->name('session.25');
