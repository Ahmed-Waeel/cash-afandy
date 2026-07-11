<?php

use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

test('profile page can be rendered', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins-api')->get(route('api.dashboard.profile.show'));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins-api')->put(route('api.dashboard.profile.update'), [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
    ]);

    $response->assertOk();
});

test('admin can update password', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins-api')->put(route('api.dashboard.profile.update'), [
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertOk();

    $admin->refresh();
    $this->assertTrue(Hash::check('new-password', $admin->password));
});

test('admin can update profile picture', function () {
    $user = Admin::factory()->create();

    $response = $this->actingAs($user, 'admins-api')->put(route('api.dashboard.profile.update'), [
        'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
    ]);

    $response->assertOk();

    $user->refresh();

    $this->assertNotNull($user->profile_picture);
});
