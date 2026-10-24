<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected MP3 Music Player Route
Route::middleware('auth')->group(function () {
    Route::get('/player', function () {
        return view('player');
    })->name('player');
});

Route::get('/blog', function () {
    return view('blog');
});
