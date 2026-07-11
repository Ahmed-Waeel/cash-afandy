<?php

use App\Models\Admin;
use Redot\Models\Language;

it('can revert a language token', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin, 'admins');

    $language = Language::firstOrCreate(['code' => 'en'], ['name' => 'English']);
    $token = $language->tokens()->firstOrCreate(['key' => fake()->unique()->word], [
        'value' => fake()->sentence,
        'original_translation' => fake()->sentence,
    ]);

    $response = $this->get(route('dashboard.languages.tokens.revert', $language));

    $response->assertRedirect();
    $response->assertSessionHas('success');
    $response->assertSessionHasNoErrors();

    $token->refresh();

    $this->assertEquals($token->value, $token->original_translation);
});
