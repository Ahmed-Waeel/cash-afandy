<?php

use App\Models\Admin;

test('roles can be listed by an authenticated admin', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins-api')->get(route('api.dashboard.roles.index'));

    $response->assertOk();
});
