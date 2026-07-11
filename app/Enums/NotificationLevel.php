<?php

namespace App\Enums;

enum NotificationLevel: string
{
    case Info = 'info';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
    case Error = 'error';

    /**
     * Get the levels as a value => label map.
     *
     * @return array<string, string>
     */
    public static function values(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $level) => [$level->value => $level->label()])
            ->all();
    }

    /**
     * Resolve the notification level from a string.
     */
    public static function resolve(string|self|null $level = null): self
    {
        if ($level instanceof self) return $level;
        if (is_string($level)) return self::tryFrom($level) ?? self::Info;

        return self::Info;
    }

    /**
     * Get the label for the notification level.
     */
    public function label(): string
    {
        return match ($this) {
            self::Info => __('Info'),
            self::Success => __('Success'),
            self::Warning => __('Warning'),
            self::Danger => __('Danger'),
            self::Error => __('Error'),
        };
    }

    /**
     * Get the color for the notification level.
     */
    public function color(): string
    {
        return match ($this) {
            self::Info => 'info',
            self::Success => 'success',
            self::Warning => 'warning',
            self::Danger, self::Error => 'danger',
        };
    }
}
