<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Bus;
use Redot\Jobs\PublishLanguageTokens;
use Redot\Models\Language;

test('publish language tokens run the job synchronously', function () {
    Bus::fake();

    $admin = Admin::factory()->create();
    $language = Language::firstOrCreate(['code' => 'en'], ['name' => 'English']);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.languages.tokens.publish', $language));

    $response->assertRedirect();

    Bus::assertDispatchedSync(PublishLanguageTokens::class);
});
