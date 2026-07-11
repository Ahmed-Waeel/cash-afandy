<?php

use App\Models\Admin;
use App\Models\User;

/**
 * Get a static page url by the given slug.
 */
function static_page_url(string $slug, array $parameters = [], bool $absolute = true): string
{
    return route('website.static-pages.show', array_merge($parameters, ['staticPage' => $slug]), $absolute);
}

/**
 * Get the current logged in admin.
 */
function current_admin(): ?Admin
{
    return auth('admins')->user() ?? auth('admins-api')->user();
}

/**
 * Get the current logged in user.
 */
function current_user(): ?User
{
    return auth('users')->user() ?? auth('users-api')->user();
}

/**
 * Determine whether the current request belongs to the dashboard scope.
 */
function is_dashboard_request(): bool
{
    if (request()->routeIs('dashboard.*')) {
        return true;
    }

    // Unmatched requests (e.g. 404s) carry no dashboard route, so compare the
    // URL against the dashboard root, which already reflects the configured
    // prefix and the current locale.
    $root = route('dashboard.index');

    return url()->current() === $root || str_starts_with(url()->current(), "{$root}/");
}
