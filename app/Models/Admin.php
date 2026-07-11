<?php

namespace App\Models;

use Database\Factories\AdminFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable;

    /** @use HasFactory<AdminFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'active' => 'boolean',
        'last_login_at' => 'datetime',
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
            'name' => [
                'title' => __('Name'),
                'type' => 'string',
            ],
            'email' => [
                'title' => __('Email'),
                'type' => 'string',
            ],
            'active' => [
                'title' => __('Active'),
                'type' => 'boolean',
            ],
            'last_login_at' => [
                'title' => __('Last Login At'),
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
     * Perform any actions required after the model boots.
     */
    protected static function booted(): void
    {
        ResetPassword::createUrlUsing(function (Admin $admin, string $token) {
            return url(route('dashboard.password.reset', [
                'token' => $token,
                'email' => $admin->email,
            ], false));
        });
    }

    /**
     * Scope a query to only include admins that are not the current admin.
     */
    public function scopeWhereNotCurrentAdmin($query): void
    {
        $query->where('id', '!=', auth('admins')->id());
    }

    /**
     * Scope a query to only include active admins.
     */
    public function scopeActive($query): void
    {
        $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive admins.
     */
    public function scopeInactive($query): void
    {
        $query->where('active', false);
    }

    /**
     * Scope a query to only include admins that have logged in.
     */
    public function scopeLoggedIn($query): void
    {
        $query->whereNotNull('last_login_at');
    }

    /**
     * Scope a query to only include admins that have not logged in.
     */
    public function scopeNotLoggedIn($query): void
    {
        $query->whereNull('last_login_at');
    }
}
