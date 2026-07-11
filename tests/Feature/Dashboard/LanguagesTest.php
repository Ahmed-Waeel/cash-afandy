<?php

use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Redot\Models\Language;

test('admin can see a list of languages', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.languages.index'));

    $response->assertOk();
});

test('admin can see create form of language', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.languages.create'));

    $response->assertOk();
});

test('admin can create a language', function () {
    $admin = Admin::factory()->create();

    $code = fake()->languageCode;
    while (Language::where('code', $code)->exists()) {
        $code = fake()->languageCode;
    }

    $response = $this->actingAs($admin, 'admins')->post(route('dashboard.languages.store'), [
        'name' => fake()->name,
        'code' => $code,
        'source' => Language::inRandomOrder()->first()->code,
        'direction' => fake()->randomElement(['ltr', 'rtl']),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Delete the language files
    File::deleteDirectory(lang_path($code));
    File::delete(lang_path($code . '.json'));
});
