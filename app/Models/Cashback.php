<?php

namespace App\Models;

use Database\Factories\CashbackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Cashback extends Model
{
    /** @use HasFactory<CashbackFactory> */
    use HasFactory;

    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'percentage',
        'details',
        'client_id',
        'representative_id',
        'country_id',
        'terms',
        'how_it_works',
        'verification_period',
        'tips',
        'launch_date',
        'expiration_date',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'array',
        'launch_date' => 'datetime',
        'expiration_date' => 'datetime',
        'active' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'terms',
        'how_it_works',
        'tips',
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
            'percentage' => [
                'title' => __('Percentage'),
                'type' => 'float',
            ],
            'active' => [
                'title' => __('Active'),
                'type' => 'boolean',
            ],
            'launch_date' => [
                'title' => __('Launch Date'),
                'type' => 'datetime',
            ],
            'expiration_date' => [
                'title' => __('Expiration Date'),
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
     * Get the client that owns the cashback.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the representative that owns the cashback.
     */
    public function representative(): BelongsTo
    {
        return $this->belongsTo(Representative::class);
    }

    /**
     * Get the country the cashback is available in.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
