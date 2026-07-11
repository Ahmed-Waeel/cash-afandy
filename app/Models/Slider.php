<?php

namespace App\Models;

use Database\Factories\SliderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Redot\Traits\UserAuditable;

class Slider extends Model
{
    /** @use HasFactory<SliderFactory> */
    use HasFactory;

    use UserAuditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'locale',
        'title',
        'description',
        'foreground',
        'background',
        'background_size',
        'image',
        'buttons',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'buttons' => 'array',
        'active' => 'boolean',
    ];
}
