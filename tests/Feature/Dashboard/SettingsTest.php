<?php

use App\Models\Admin;

test('admins can view the settings page', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.settings.edit'));

    $response->assertStatus(200);
});

test('admins can update the settings', function () {
    $admin = Admin::factory()->create();

    $names = [];
    foreach (array_keys(config('app.locales')) as $locale) {
        $names[$locale] = fake($locale)->word;
    }

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.settings.update'), [
        'app_name' => $names,
        'website_locales' => ['en'],
        'dashboard_locales' => ['en'],
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});
