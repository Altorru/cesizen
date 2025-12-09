<?php

use App\Http\Controllers\Admin\ContentPageController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Admin routes - protected by auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Content Management
    Route::resource('content-pages', ContentPageController::class);

    // Users Management (placeholder for now)
    Route::get('/users', fn () => response()->json(['message' => 'Users management coming soon']))->name('users.index');
});
