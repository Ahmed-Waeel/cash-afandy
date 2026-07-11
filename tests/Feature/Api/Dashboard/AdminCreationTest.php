<?php

use App\Models\Admin;
use App\Notifications\NewAdminNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

test('admin can register a new admin', function () {
    Notification::fake();

    $admin = Admin::factory()->create();
    $role = Role::create(['name' => uniqid('role-')]);

    $data = [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
        'role' => $role->name,
    ];

    $response = $this->actingAs($admin, 'admins-api')->post(route('api.dashboard.admins.store'), $data);
    $created = Admin::whereEmail($data['email'])->first();

    Notification::assertSentTo($created, NewAdminNotification::class);

    $response->assertOk();
});
