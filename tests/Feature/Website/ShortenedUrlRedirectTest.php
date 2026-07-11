<?php

use App\Models\ShortenedUrl;

test('redirect to the shortened URL', function () {
    $shortenedUrl = ShortenedUrl::factory()->create();

    $response = $this->withHeaders([
        'referer' => 'https://example.test/source-page',
        'user-agent' => 'Pest Browser',
        'accept-language' => 'en-US,en;q=0.9',
    ])->get(route('website.shortened-urls.show', [
        'shortenedUrl' => $shortenedUrl,
        'utm_source' => 'newsletter',
        'utm_medium' => 'email',
        'utm_campaign' => 'spring_launch',
    ]));

    $response->assertRedirect($shortenedUrl->url);
    $this->assertDatabaseHas('shortened_urls', [
        'id' => $shortenedUrl->id,
        'clicks' => $shortenedUrl->clicks + 1,
    ]);
});
