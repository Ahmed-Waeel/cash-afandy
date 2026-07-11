<?php

namespace App\Models;

use Database\Factories\MemoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Memo extends Model
{
    /** @use HasFactory<MemoFactory> */
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'title',
        'icon',
        'date',
        'content',
        'attachments',
    ];

    /**
     * Attributes that should be cast to native types.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'attachments' => 'array',
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
            'admin_id' => [
                'title' => __('Admin'),
                'type' => 'integer',
                'values' => fn () => Admin::all()->pluck('name', 'id'),
            ],
            'title' => [
                'title' => __('Title'),
                'type' => 'string',
            ],
            'icon' => [
                'title' => __('Icon'),
                'type' => 'string',
            ],
            'date' => [
                'title' => __('Date'),
                'type' => 'datetime',
            ],
            'content' => [
                'title' => __('Content'),
                'type' => 'string',
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
     * Memo belongs to Admin.
     *
     * @return BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope a query to only include memos for the authenticated admin.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeForAuthenticatedAdmin($query)
    {
        $adminId = auth('admins')->id();

        return $query->where('admin_id', $adminId);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)->forAuthenticatedAdmin()->first() ?? abort(404);
    }
}
