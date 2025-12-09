<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

beforeEach(function (): void {
    // Create a test route protected by admin middleware
    Route::middleware(['web', 'auth', 'admin'])->get('/admin/test', function () {
        return response()->json(['message' => 'Admin access granted']);
    });
});

test('admin user can access admin routes', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/test')
        ->assertStatus(200)
        ->assertJson(['message' => 'Admin access granted']);
});

test('regular user cannot access admin routes', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/test')
        ->assertStatus(403);
});

test('guest user cannot access admin routes', function (): void {
    $this->get('/admin/test')
        ->assertRedirect('/login');
});
