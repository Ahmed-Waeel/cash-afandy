<?php

namespace App\Enums;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';

    /**
     * Get the genders as a value => label map.
     *
     * @return array<string, string>
     */
    public static function values(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $gender) => [$gender->value => $gender->label()])
            ->all();
    }

    /**
     * Get the label for the gender.
     */
    public function label(): string
    {
        return match ($this) {
            self::Male => __('Male'),
            self::Female => __('Female'),
        };
    }
}
