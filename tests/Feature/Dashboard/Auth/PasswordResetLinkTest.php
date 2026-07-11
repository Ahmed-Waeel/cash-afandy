<?php

use App\Models\Admin;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('reset password link screen can be rendered', function () {
    $response = $this->get(route('dashboard.password.request'));

    $response->assertOk();
});

test('reset password link can be requested', function () {
    Notification::fake();

    $admin = Admin::factory()->create();

    $this->post(route('dashboard.password.email'), [
        'email' => $admin->email,
    ]);

    Notification::assertSentTo($admin, ResetPassword::class);
});
