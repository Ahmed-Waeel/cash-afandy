<?php

use App\Models\StaticPage;

test('static page can be displayed', function () {
    $staticPage = StaticPage::factory()->create();

    $response = $this->get(route('website.static-pages.show', $staticPage));

    $response->assertOk();
    $response->assertSee($staticPage->title);
});

test('static page returns 404 for non-existent page', function () {
    $response = $this->get(route('website.static-pages.show', 'non-existent-slug'));

    $response->assertNotFound();
});
