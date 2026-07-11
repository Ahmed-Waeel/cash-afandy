<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

beforeEach(function () {
    $this->withoutMiddleware(ThrottleRequests::class);
});

test('email can be verified', function () {
    Event::fake();

    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute(
        'website.verification.verify',
        now()->addMinutes(60),
        ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
    );

    $response = $this->actingAs($user, 'users')->get($url);

    Event::assertDispatched(Verified::class);

    $response->assertRedirect(route('website.index') . '?verified=1');
    $this->assertNotNull($user->fresh()->email_verified_at);
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute(
        'website.verification.verify',
        now()->addMinutes(60),
        ['id' => $user->getKey(), 'hash' => sha1('invalid-email')]
    );

    $response = $this->actingAs($user, 'users')->get($url);

    $response->assertForbidden();
});

test('user cannot verify a verified email', function () {
    $user = User::factory()->verified()->create();

    $url = URL::temporarySignedRoute(
        'website.verification.verify',
        now()->addMinutes(60),
        ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
    );

    $response = $this->actingAs($user, 'users')->get($url);

    $response->assertRedirect(route('website.index') . '?verified=1');
});
