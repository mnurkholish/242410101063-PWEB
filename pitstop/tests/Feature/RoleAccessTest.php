<?php

use App\Models\User;

test('admin is redirected to admin dashboard after login', function () {
    $user = User::factory()->admin()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('user cannot access admin dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/dashboard');

    $response->assertRedirect(route('dashboard', absolute: false));
});

test('admin cannot access user dashboard', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('admin.dashboard', absolute: false));
});
