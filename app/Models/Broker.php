<?php

namespace App\Models;

use Database\Factories\BrokerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broker extends Model
{
    /** @use HasFactory<BrokerFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'email',
        'phone',
        'url',
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
            'email' => [
                'title' => __('Email'),
                'type' => 'string',
            ],
            'phone' => [
                'title' => __('Phone'),
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
     * Get the representatives for the broker.
     */
    public function representatives(): HasMany
    {
        return $this->hasMany(Representative::class);
    }
}
