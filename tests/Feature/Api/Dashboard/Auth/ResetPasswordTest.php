<?php

use App\Models\Admin;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('admin can reset password', function () {
    Notification::fake();

    $admin = Admin::factory()->create();

    $this->post(route('api.dashboard.password.email'), [
        'email' => $admin->email,
    ]);

    Notification::assertSentTo($admin, ResetPassword::class, function ($notification) use ($admin) {
        $response = $this->post(route('api.dashboard.password.store'), [
            'token' => $notification->token,
            'email' => $admin->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        return true;
    });
});

test('admin cannot reset password with invalid token', function () {
    Notification::fake();

    $admin = Admin::factory()->create();

    $this->post(route('api.dashboard.password.email'), [
        'email' => $admin->email,
    ]);

    Notification::assertSentTo($admin, ResetPassword::class, function ($notification) use ($admin) {
        $response = $this->post(route('api.dashboard.password.store'), [
            'token' => 'invalid-token',
            'email' => $admin->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);

        return true;
    });
});
