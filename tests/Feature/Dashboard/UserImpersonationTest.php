<?php

use App\Models\Admin;
use App\Models\User;

test('admin can see user impersonate form', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.impersonate-users.create'));

    $response->assertOk();
});

test('admin can impersonate a user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.impersonate-users.store'), [
        'user_id' => $user->id,
    ]);

    $response->assertRedirect(route('website.index'));

    $this->assertAuthenticatedAs($user, 'users');
});
