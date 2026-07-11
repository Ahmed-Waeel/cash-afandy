<?php

use App\Models\Admin;
use Spatie\Permission\Models\Role;

test('admin can see admins list', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.admins.index'));

    $response->assertOk();
});

test('admin can create a new admin', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.admins.create'));

    $response->assertOk();
});

test('admin can store a new admin', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => fake()->word]);

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.admins.store'), [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
        'role' => $role->name,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('admin can see edit form of an admin', function () {
    $admin = Admin::factory()->create();
    $adminToEdit = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.admins.edit', $adminToEdit));

    $response->assertOk();
});

test('admin can update an admin', function () {
    $admin = Admin::factory()->create();
    $adminToUpdate = Admin::factory()->create();
    $role = Role::create(['name' => fake()->word]);

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.admins.update', $adminToUpdate), [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
        'role' => $role->name,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('admin can delete an admin', function () {
    $admin = Admin::factory()->create();
    $adminToDelete = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.admins.destroy', $adminToDelete));

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('admin cannot delete himself', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.admins.destroy', $admin));

    $response->assertSessionHas('error');
});
