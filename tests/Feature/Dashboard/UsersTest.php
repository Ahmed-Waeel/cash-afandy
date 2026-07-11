<?php

use App\Models\Admin;
use App\Models\User;

test('admin can see users list', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.users.index'));

    $response->assertOk();
});

test('admin can create a new user', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.users.create'));

    $response->assertOk();
});

test('admin can store a new user', function () {
    $admin = Admin::factory()->create();

    $data = [
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
        'email' => fake()->unique()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.users.store'), $data);

    $response->assertRedirect(route('dashboard.users.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'email' => $data['email'],
    ]);
});

test('admin can see a user details', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.users.show', $user));

    $response->assertOk();
});

test('admin can see the edit form of a user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.users.edit', $user));

    $response->assertOk();
});

test('admin can update a user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $data = [
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
    ];

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.users.update', $user), $data);

    $response->assertSessionHasNoErrors();

    $user->refresh();

    $this->assertEquals($data['first_name'], $user->first_name);
    $this->assertEquals($data['last_name'], $user->last_name);
});

test('admin can delete a user', function () {
    $admin = Admin::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.users.destroy', $user));

    $response->assertSessionHasNoErrors();

    $this->assertSoftDeleted($user);
});
