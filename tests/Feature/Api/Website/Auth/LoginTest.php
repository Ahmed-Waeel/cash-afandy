<?php

use App\Models\User;

test('user can login', function () {
    $user = User::factory()->create();

    $response = $this->post(route('api.website.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['payload' => ['token', 'token_type']]);
});

test('user can destroy session', function () {
    $user = User::factory()->create();

    $token = $user->createToken('auth_token')->plainTextToken;

    $response = $this->deleteJson(route('api.website.logout'), [], [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertOk();
});
