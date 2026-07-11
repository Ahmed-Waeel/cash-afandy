<?php

use App\Models\Admin;

test('admin can login', function () {
    $admin = Admin::factory()->create();

    $response = $this->post(route('api.dashboard.login.store'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['payload' => ['token', 'token_type']]);
});

test('admin can destroy session', function () {
    $admin = Admin::factory()->create();

    $token = $admin->createToken('auth_token')->plainTextToken;

    $response = $this->delete(route('api.dashboard.logout'), [], [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertOk();
});
