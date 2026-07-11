<?php

use App\Models\User;

test('email verification screen can be rendered for unverified user', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user, 'users')->get(route('website.verification.notice'));

    $response->assertOk();
});

test('email verification screen cannot be rendered for verified user', function () {
    $user = User::factory()->verified()->create();

    $response = $this->actingAs($user, 'users')->get(route('website.verification.notice'));

    $response->assertRedirect(route('website.index'));
});
