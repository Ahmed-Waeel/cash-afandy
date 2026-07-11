<?php

use App\Models\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('admin can see roles list', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.roles.index'));

    $response->assertOk();
});

test('admin can create a role', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.roles.create'));

    $response->assertOk();
});

test('admin can store a role', function () {
    $admin = Admin::factory()->create();
    $permission = Permission::create(['name' => fake()->word]);

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.roles.store'), [
        'name' => fake()->word,
        'permissions' => [$permission->name],
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('dashboard.roles.index'));
});

test('admin can edit a role', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => fake()->word]);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.roles.edit', $role));

    $response->assertOk();
});

test('admin can update a role', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => fake()->word]);
    $permission = Permission::create(['name' => fake()->word]);

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.roles.update', $role), [
        'name' => fake()->word,
        'permissions' => [$permission->name],
    ]);

    $response->assertSessionHasNoErrors();
});

test('admin can delete a role', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => fake()->word]);

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.roles.destroy', $role));

    $response->assertSessionHasNoErrors();
});

test('admin cannot delete a role that has users', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => fake()->word]);
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.roles.destroy', $role));

    $response->assertSessionHas('error');
    $response->assertRedirect();
});

test('route "dashboard.roles.edit" should be permitted to at least one role', function () {
    Permission::query()->delete();
    Role::query()->delete();

    $permission = Permission::create(['name' => 'dashboard.roles.edit']);

    $role = Role::create(['name' => fake()->word]);
    $role->givePermissionTo($permission);

    $admin = Admin::factory()->create();
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.roles.update', $role), [
        'name' => fake()->word,
        'permissions' => [],
    ]);

    $response->assertSessionHas('error');
    $response->assertRedirect();
});
