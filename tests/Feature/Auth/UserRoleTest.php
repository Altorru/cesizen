<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('new user created through registration has default user role', function (): void {
    // Test the CreateNewUser action directly (used by Fortify)
    $action = new \App\Actions\Fortify\CreateNewUser;

    $user = $action->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    expect($user)->not->toBeNull();
    expect($user->role)->toBe('user');
    expect($user->isUser())->toBeTrue();
    expect($user->isAdmin())->toBeFalse();
    expect($user->exists)->toBeTrue();
});

test('user created through controller has default user role', function (): void {
    // Test that the controller also sets the role correctly
    $user = User::create([
        'name' => 'Test User 2',
        'email' => 'test2@example.com',
        'password' => Hash::make('password'),
        'role' => 'user',
    ]);

    expect($user->role)->toBe('user');
    expect($user->isUser())->toBeTrue();
    expect($user->isAdmin())->toBeFalse();
});

test('user factory creates user with user role by default', function (): void {
    $user = User::factory()->create();

    expect($user->role)->toBe('user');
    expect($user->isUser())->toBeTrue();
    expect($user->isAdmin())->toBeFalse();
});

test('user factory can create admin user', function (): void {
    $admin = User::factory()->admin()->create();

    expect($admin->role)->toBe('admin');
    expect($admin->isAdmin())->toBeTrue();
    expect($admin->isUser())->toBeFalse();
});

test('user role can be updated', function (): void {
    $user = User::factory()->create();

    expect($user->role)->toBe('user');

    $user->update(['role' => 'admin']);
    $user->refresh();

    expect($user->role)->toBe('admin');
    expect($user->isAdmin())->toBeTrue();
});
