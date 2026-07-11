<?php

use App\Models\Admin;
use App\Models\ShortenedUrl;

test('shortened urls index page can be rendered', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.shortened-urls.index'));

    $response->assertOk();
});

test('shortened urls create page can be rendered', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.shortened-urls.create'));

    $response->assertOk();
});

test('shortened urls can be created', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.shortened-urls.store'), [
        'url' => fake()->url,
        'title' => fake()->sentence(4),
        'slug' => fake()->slug,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('slug is generated automatically if not provided', function () {
    $admin = Admin::factory()->create();

    $data = [
        'url' => fake()->url,
        'title' => fake()->sentence(4),
    ];

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.shortened-urls.store'), $data);

    $response->assertRedirect();

    $shortenedUrl = ShortenedUrl::where('url', $data['url'])->first();

    $this->assertNotNull($shortenedUrl->slug);
});

test('shortened urls edit page can be rendered', function () {
    $admin = Admin::factory()->create();
    $shortenedUrl = ShortenedUrl::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.shortened-urls.edit', $shortenedUrl));

    $response->assertOk();
});

test('shortened urls title can be updated', function () {
    $admin = Admin::factory()->create();
    $shortenedUrl = ShortenedUrl::factory()->create();

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.shortened-urls.update', $shortenedUrl), [
        'title' => fake()->sentence(4),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('shortened urls can be deleted', function () {
    $admin = Admin::factory()->create();
    $shortenedUrl = ShortenedUrl::factory()->create();

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.shortened-urls.destroy', $shortenedUrl));

    $response->assertRedirect();
    $response->assertSessionHas('success');
});
