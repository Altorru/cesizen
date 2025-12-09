<?php

use App\Models\User;

test('settings page is displayed', function (): void {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/settings/profile');

    $response->assertStatus(200);
});
