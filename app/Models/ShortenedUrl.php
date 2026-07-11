<?php

namespace App\Models;

use Database\Factories\ShortenedUrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Redot\Traits\Taggable;
use Redot\Traits\UserAuditable;

class ShortenedUrl extends Model
{
    /** @use HasFactory<ShortenedUrlFactory> */
    use HasFactory;

    use SoftDeletes, Taggable, UserAuditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'slug',
        'title',
        'clicks',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Get the table schema for query builder filters.
     *
     * @return array<string, array{title: string, type: string}>
     */
    public static function getTableSchema(): array
    {
        $admins = Admin::all()->pluck('name', 'id');

        return [
            'id' => [
                'title' => __('ID'),
                'type' => 'integer',
            ],
            'url' => [
                'title' => __('URL'),
                'type' => 'string',
            ],
            'slug' => [
                'title' => __('Slug'),
                'type' => 'string',
            ],
            'title' => [
                'title' => __('Title'),
                'type' => 'string',
            ],
            'clicks' => [
                'title' => __('Clicks'),
                'type' => 'integer',
            ],
            'created_by' => [
                'title' => __('Created By'),
                'type' => 'integer',
                'values' => $admins,
            ],
            'updated_by' => [
                'title' => __('Updated By'),
                'type' => 'integer',
                'values' => $admins,
            ],
            'deleted_by' => [
                'title' => __('Deleted By'),
                'type' => 'integer',
                'values' => $admins,
            ],
            'deleted_at' => [
                'title' => __('Deleted At'),
                'type' => 'datetime',
            ],
            'created_at' => [
                'title' => __('Created At'),
                'type' => 'datetime',
            ],
            'updated_at' => [
                'title' => __('Updated At'),
                'type' => 'datetime',
            ],
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate a unique slug.
     */
    public static function generateUniqueSlug(): string
    {
        $slug = Str::random(8);

        while (self::withTrashed()->where('slug', $slug)->exists()) {
            $slug = Str::random(8);
        }

        return $slug;
    }
}
