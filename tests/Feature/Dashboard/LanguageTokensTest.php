<?php

use App\Models\Admin;
use Redot\Models\Language;

test('admin can see list of language tokens', function () {
    $admin = Admin::factory()->create();
    $language = Language::firstOrCreate(['code' => 'en'], ['name' => 'English']);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.languages.tokens.index', $language));

    $response->assertOk();
});

test('admin can see edit form of language token', function () {
    $admin = Admin::factory()->create();
    $language = Language::firstOrCreate(['code' => 'en'], ['name' => 'English']);
    $token = $language->tokens()->firstOrCreate(['key' => fake()->unique()->word], [
        'value' => fake()->sentence,
        'original_translation' => fake()->sentence,
    ]);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.languages.tokens.edit', [$language, $token]));

    $response->assertOk();
});

test('admin can update language token', function () {
    $admin = Admin::factory()->create();
    $language = Language::firstOrCreate(['code' => 'en'], ['name' => 'English']);
    $token = $language->tokens()->firstOrCreate(['key' => fake()->unique()->word], [
        'value' => fake()->sentence,
        'original_translation' => fake()->sentence,
    ]);

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.languages.tokens.update', [$language, $token]), [
        'value' => $value = fake()->sentence,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
    $response->assertSessionHasNoErrors();

    $this->assertEquals($value, $token->refresh()->value);
});
