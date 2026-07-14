<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'gender',
    ];

    protected $casts = [
        'gender' => Gender::class,
    ];

    /**
     * Get the user associated with the subscriber if exists.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }
}
