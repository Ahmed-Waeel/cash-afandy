<?php

use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

test('profile page is displayed', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.profile.edit'));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.profile.update'), [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
    ]);

    $response->assertSessionHasNoErrors();

    $admin->refresh();
});

test('admin can update password', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.profile.update'), [
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasNoErrors();

    $admin->refresh();
    $this->assertTrue(Hash::check('new-password', $admin->password));
});

test('admin can update profile picture', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.profile.update'), [
        'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
    ]);

    $response->assertSessionHasNoErrors();

    $admin->refresh();

    $this->assertNotNull($admin->profile_picture);
});
