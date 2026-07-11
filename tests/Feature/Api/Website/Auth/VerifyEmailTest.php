<?php

use App\Models\User;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\URL;

beforeEach(function () {
    $this->withoutMiddleware(ThrottleRequests::class);
});

test('email can be verified if it is not already verified and hash is valid', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute(
        'api.website.verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user, 'users-api')->get($url);

    $response->assertOk();

    $this->assertTrue($user->fresh()->hasVerifiedEmail());
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute(
        'api.website.verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => sha1('invalid-email')]
    );

    $response = $this->actingAs($user, 'users-api')->get($url);

    $response->assertForbidden();
});

test('email is not verified if it is already verified', function () {
    $user = User::factory()->verified()->create();

    $url = URL::temporarySignedRoute(
        'api.website.verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user, 'users-api')->get($url);

    $response->assertForbidden();
});
