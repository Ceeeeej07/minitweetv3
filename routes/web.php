<?php

use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    if (Auth::check()) {

        return redirect('/twitter');
    }

    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/twitter', [TweetController::class, 'index'])->name('tweets.index');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::post('/tweets/{id}/like', [TweetController::class, 'like'])->name('tweets.like');
    Route::delete('/tweets/{id}/like', [TweetController::class, 'unlike'])->name('tweets.unlike');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
