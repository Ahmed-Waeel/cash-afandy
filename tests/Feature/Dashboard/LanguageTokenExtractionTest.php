<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Bus;
use Redot\Jobs\ExtractLanguageTokens;
use Redot\Models\Language;

test('extract language tokens run the job synchronously', function () {
    Bus::fake();

    $admin = Admin::factory()->create();
    $language = Language::firstOrCreate(['code' => 'en'], ['name' => 'English']);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.languages.tokens.extract', $language));

    $response->assertRedirect();

    Bus::assertDispatchedSync(ExtractLanguageTokens::class);
});
