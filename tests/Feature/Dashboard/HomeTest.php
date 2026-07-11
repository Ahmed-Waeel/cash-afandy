<?php

use App\Models\Admin;

test('home page can be rendered', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.index'));

    $response->assertOk();
});
