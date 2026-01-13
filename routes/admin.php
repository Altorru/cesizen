<?php

use App\Http\Controllers\Admin\ContentPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Admin routes - protected by auth and admin middleware
Route::middleware(['auth', 'active', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Content Management
    Route::resource('content-pages', ContentPageController::class);

    // Users Management
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});
