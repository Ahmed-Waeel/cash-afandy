<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Redot\Traits\Taggable;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'locale',
        'category_id',
        'excerpt',
        'content',
        'cover_image',
        'media_type',
        'media',
        'thumbnail',
        'tags',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Get the table schema for query builder filters.
     *
     * @return array<string, array{title: string, type: string}>
     */
    public static function getTableSchema(): array
    {
        return [
            'id' => [
                'title' => __('ID'),
                'type' => 'integer',
            ],
            'title' => [
                'title' => __('Title'),
                'type' => 'string',
            ],
            'slug' => [
                'title' => __('Slug'),
                'type' => 'string',
            ],
            'locale' => [
                'title' => __('Locale'),
                'type' => 'string',
            ],
            'published_at' => [
                'title' => __('Published At'),
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
     * Scope a query to only include published posts.
     */
    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include unpublished posts.
     */
    public function scopeUnpublished(Builder $query): void
    {
        $query->whereNull('published_at')->orWhere('published_at', '>', now());
    }

    /**
     * Get the category that owns the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
