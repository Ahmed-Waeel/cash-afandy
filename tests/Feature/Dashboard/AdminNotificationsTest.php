<?php

use App\Models\Admin;
use App\Notifications\DashboardNotification;
use Illuminate\Support\Facades\Notification;

test('admin notifications create page can be rendered', function () {
    $this->actingAs(Admin::factory()->create(), 'admins');

    $response = $this->get(route('dashboard.admin-notifications.create'));

    $response->assertOk();
});

test('a custom notification can be sent to administrators', function () {
    Notification::fake();

    $sender = Admin::factory()->create();
    $recipient = Admin::factory()->create();

    $response = $this->actingAs($sender, 'admins')->post(route('dashboard.admin-notifications.store'), [
        'admins' => [$sender->id, $recipient->id],
        'title' => fake()->sentence(4),
        'level' => 'info',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    Notification::assertSentTo([$sender, $recipient], DashboardNotification::class);
});
