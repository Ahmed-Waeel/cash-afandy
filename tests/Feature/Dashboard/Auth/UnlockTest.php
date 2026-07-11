<?php

use App\Models\Admin;

test('unlock screen can be rendered', function () {
    $this->be(Admin::factory()->create());

    $this->post(route('dashboard.lock'));
    $response = $this->get(route('dashboard.unlock'));

    $response->assertOk();
});

test('admin redirected to dashboard if not locked', function () {
    $this->be(Admin::factory()->create());

    $response = $this->get(route('dashboard.unlock'));

    $response->assertRedirect(route('dashboard.index'));
});

test('admin can unlock the dashboard screen', function () {
    $this->be(Admin::factory()->create());

    $response = $this->post(route('dashboard.lock'));
    $response->assertSessionHas('auth.admins.locked', true);

    $response = $this->post(route('dashboard.unlock.store'), [
        'password' => 'password',
    ]);

    $response->assertSessionMissing('dashboard_locked');
});

test('admin cannot unlock the dashboard screen with incorrect password', function () {
    $this->be(Admin::factory()->create());

    $response = $this->post(route('dashboard.lock'));
    $response->assertSessionHas('auth.admins.locked', true);

    $response = $this->post(route('dashboard.unlock.store'), [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('password');
});
