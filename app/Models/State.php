<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'country_id',
        'country_code',
        'title',
        'native',
        'iso2',
        'iso3166_2',
        'latitude',
        'longitude',
        'timezone',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get states by country code.
     */
    public static function code(string $code): ?Collection
    {
        return static::where('country_code', $code)->get();
    }

    /**
     * Get the country that owns the state.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
