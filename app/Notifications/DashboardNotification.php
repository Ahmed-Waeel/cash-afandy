<?php

namespace App\Notifications;

use App\Enums\NotificationLevel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DashboardNotification extends Notification
{
    use Queueable;

    /**
     * The title of the notification.
     */
    public string $title;

    /**
     * The URL of the notification.
     */
    public ?string $url = null;

    /**
     * The level of the notification.
     */
    public NotificationLevel $level = NotificationLevel::Info;

    /**
     * The extra data for the notification.
     */
    public array $data = [];

    /**
     * Create a new notification instance.
     */
    public function __construct(string $title, ?string $url = null, NotificationLevel|string|null $level = null, array $data = [])
    {
        $this->title = $title;
        $this->url = $url;
        $this->level = NotificationLevel::resolve($level);
        $this->data = $data;
    }

    /**
     * Make a new notification instance statically.
     */
    public static function make(string $title, ?string $url = null, NotificationLevel|string|null $level = null, array $data = []): static
    {
        return new static($title, $url, $level, $data);
    }

    /**
     * Set the title of the notification.
     */
    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the URL of the notification.
     */
    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the level of the notification.
     */
    public function level(NotificationLevel|string $level): static
    {
        $this->level = NotificationLevel::resolve($level);

        return $this;
    }

    /**
     * Set the extra data for the notification.
     */
    public function data(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'level' => $this->level->value,
            'data' => $this->data,
        ];
    }
}
