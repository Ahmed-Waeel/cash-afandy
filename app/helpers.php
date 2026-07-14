<?php

use App\Models\Admin;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Location\Facades\Location;

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

/**
 * Get the website's currently selected country.
 *
 * Resolution order: an explicit `?country=` query param, the previously
 * selected country in the session, then the visitor's IP-detected country -
 * restricted to the countries the website currently supports.
 */
function website_country(): Country
{
    $codes = setting('website_countries');
    $default = setting('default_website_country');

    $code = request()->query('country');

    if ($code && in_array($code, $codes, true)) {
        session()->put('website_country', $code);
    } else {
        $code = session('website_country');
    }

    if (! in_array($code, $codes, true)) {
        $code = Cache::remember(
            'website-country-ip:' . request()->ip(),
            now()->addDay(),
            function () {
                $position = Location::get();

                return $position ? strtolower((string) $position->countryCode) : '';
            }
        );

        if (! in_array($code, $codes, true)) {
            $code = $default;
        }

        session()->put('website_country', $code);
    }

    return Country::code($code) ?? Country::code($default);
}
