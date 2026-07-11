<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('user can request password reset', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('api.website.password.email'), [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);

    $response->assertOk();
    $response->assertJsonStructure(['message']);
});
