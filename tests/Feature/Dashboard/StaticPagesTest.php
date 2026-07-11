<?php

use App\Models\Admin;
use App\Models\StaticPage;

test('static pages index page can be rendered', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->get(route('dashboard.static-pages.index'));

    $response->assertOk();
});

test('static pages create page can be rendered', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->get(route('dashboard.static-pages.create'));

    $response->assertOk();
});

test('static pages can be created', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $data = [
        'title' => [],
        'content' => [],
    ];

    foreach (array_keys(config('app.locales')) as $locale) {
        $data['title'][$locale] = fake()->sentence(3);
        $data['content'][$locale] = fake()->paragraphs(2, true);
    }

    $response = $this->post(route('dashboard.static-pages.store'), $data);

    $response->assertRedirect(route('dashboard.static-pages.index'));
    $response->assertSessionHas('success');

    $fallbackLocale = config('app.fallback_locale');
    $this->assertDatabaseHas('static_pages', [
        "title->{$fallbackLocale}" => $data['title'][$fallbackLocale],
    ]);
});

test('static pages store validates required fields', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->post(route('dashboard.static-pages.store'), []);

    $response->assertSessionHasErrors(['title']);
});

test('static pages edit page can be rendered', function () {
    $admin = Admin::factory()->create();
    $staticPage = StaticPage::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.static-pages.edit', $staticPage));

    $response->assertOk();
});

test('static pages can be updated', function () {
    $admin = Admin::factory()->create();
    $staticPage = StaticPage::factory()->create();

    $data = [
        'title' => [],
        'content' => [],
    ];

    foreach (array_keys(config('app.locales')) as $locale) {
        $data['title'][$locale] = "Updated Title {$locale}";
        $data['content'][$locale] = "Updated content {$locale}";
    }

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.static-pages.update', $staticPage), $data);

    $response->assertSessionHasNoErrors();

    $staticPage->refresh();

    foreach (array_keys(config('app.locales')) as $locale) {
        expect($staticPage->getTranslation('title', $locale))->toBe("Updated Title {$locale}");
    }
});

test('static pages update validates required fields', function () {
    $admin = Admin::factory()->create();
    $staticPage = StaticPage::factory()->create();

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.static-pages.update', $staticPage), []);

    $response->assertSessionHasErrors(['title']);
});

test('static pages can be deleted', function () {
    $admin = Admin::factory()->create();
    $staticPage = StaticPage::factory()->create();

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.static-pages.destroy', $staticPage));

    $response->assertRedirect(route('dashboard.static-pages.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('static_pages', [
        'id' => $staticPage->id,
    ]);
});
