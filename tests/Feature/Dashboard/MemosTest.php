<?php

use App\Models\Admin;
use App\Models\Memo;

test('memos index page can be rendered', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->get(route('dashboard.memos.index'));

    $response->assertOk();
});

test('memos create page can be rendered', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->get(route('dashboard.memos.create'));

    $response->assertOk();
});

test('memos can be created', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->post(route('dashboard.memos.store'), [
        'title' => fake()->sentence(4),
        'content' => fake()->sentence(10),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('memos show page can be rendered', function () {
    $admin = Admin::factory()->create();
    $memo = Memo::factory()->create(['admin_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.memos.show', $memo));

    $response->assertOk();
});

test('memos edit page can be rendered', function () {
    $admin = Admin::factory()->create();
    $memo = Memo::factory()->create(['admin_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admins')->get(route('dashboard.memos.edit', $memo));

    $response->assertOk();
});

test('memos can be updated', function () {
    $admin = Admin::factory()->create();
    $memo = Memo::factory()->create(['admin_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admins')->put(route('dashboard.memos.update', $memo), [
        'title' => fake()->sentence(4),
        'content' => fake()->sentence(10),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('memos can be deleted', function () {
    $admin = Admin::factory()->create();
    $memo = Memo::factory()->create(['admin_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admins')->delete(route('dashboard.memos.destroy', $memo));

    $response->assertRedirect();
    $response->assertSessionHas('success');
});
