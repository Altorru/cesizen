<?php

use App\Http\Controllers\ContentPageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('index'))->name('home');

// Public content pages
Route::get('/articles', [ContentPageController::class, 'index'])->name('content.index');
Route::get('/articles/{slug}', [ContentPageController::class, 'show'])->name('content.show');

Route::middleware(['auth'])->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))
        ->middleware('redirect.admin')
        ->name('dashboard');
    
    // Activities
    Route::get('activities/breathing', fn () => Inertia::render('activities/Breathing'))
        ->name('activities.breathing');
});

require __DIR__.'/admin.php';
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
