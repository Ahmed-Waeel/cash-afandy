<?php

use App\Models\Admin;

test('login screen can be rendered', function () {
    $response = $this->get(route('dashboard.login'));

    $response->assertOk();
});

test('admin can authenticate using the login screen', function () {
    $admin = Admin::factory()->create();

    $response = $this->post(route('dashboard.login'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated('admins');
    $response->assertRedirect(route('dashboard.index'));
});

test('admin can not authenticate with invalid password', function () {
    $admin = Admin::factory()->create();

    $this->post(route('dashboard.login'), [
        'email' => $admin->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest('admins');
});

test('authenticated admin can logout', function () {
    $this->be(Admin::factory()->create());

    $response = $this->post(route('dashboard.logout'));

    $this->assertGuest('admins');
    $response->assertRedirect(route('dashboard.index'));
});
