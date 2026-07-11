<?php

use App\Models\Admin;

test('qr-code page can be rendered', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admins')->get(route('dashboard.qr-code.index'))->assertOk();
});
