<?php

use App\Models\Admin;

test('admin can lock the dashboard screen', function () {
    $this->be(Admin::factory()->create());

    $response = $this->post(route('dashboard.lock'));

    $response->assertSessionHas('auth.admins.locked', true);
});
