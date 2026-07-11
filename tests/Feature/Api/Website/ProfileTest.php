<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('profile page can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'users-api')->get(route('api.website.profile.show'));

    $response->assertOk();
});

test('profile can be updated', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'users-api')->put(route('api.website.profile.update'), [
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
        'email' => fake()->unique()->safeEmail,
    ]);

    $response->assertOk();
});

test('user can update password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'users-api')->put(route('api.website.profile.update'), [
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertOk();

    $user->refresh();
    $this->assertTrue(Hash::check('new-password', $user->password));
});
