<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->withoutMiddleware(ThrottleRequests::class);
});

test('user can request email verification notification', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user, 'users-api')->post(route('api.website.verification.send'));

    Notification::assertSentTo($user, VerifyEmail::class);

    $response->assertOk();
});

test('user cannot request email verification notification if email is already verified', function () {
    $user = User::factory()->verified()->create();

    $response = $this->actingAs($user, 'users-api')->post(route('api.website.verification.send'));

    $response->assertStatus(400);
});
