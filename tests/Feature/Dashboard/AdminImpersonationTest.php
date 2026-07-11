<?php

use App\Models\Admin;

test('admin can see impersonate form', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.impersonate-admins.create'));

    $response->assertOk();
});

test('admin can impersonate another admin', function () {
    $admin = Admin::factory()->create();
    $adminToImpersonate = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.impersonate-admins.store'), [
        'admin_id' => $adminToImpersonate->id,
    ]);

    $response->assertRedirect(route('dashboard.index'));

    $this->assertAuthenticatedAs($adminToImpersonate, 'admins');
});
