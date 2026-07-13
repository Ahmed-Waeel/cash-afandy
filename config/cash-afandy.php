<?php

return [

    /*--------------------------------------------------------------------------
    | Redot Features
    |--------------------------------------------------------------------------
    |
    | The features that are enabled for the application, You can enable or
    | disable features as per your requirements.
    |
    */

    'features' => [
        'website-api' => [
            'enabled' => false,
        ],

        'dashboard-api' => [
            'enabled' => false,
            'prefix' => 'dashboard',
        ],

        'website' => [
            'enabled' => true,
        ],

        'dashboard' => [
            'enabled' => true,
            'prefix' => 'dashboard',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    |
    | The list of available locales for the website and dashboard.
    |
    */

    'locales' => [
        [
            'code' => 'en',
            'name' => 'English',
            'is_rtl' => false,
        ],

        [
            'code' => 'ar',
            'name' => 'العربية',
            'is_rtl' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | Route-level behavior that affects URL generation and fallback redirects.
    |
    */

    'routing' => [
        'append_locale_to_url' => true,
        'redirect_non_locale_urls' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Persisted application settings schema. Each setting may define a default
    | value and request validation rules for the dashboard settings form.
    |
    */

    'settings' => [
        'app_logo_dark' => [
            'default' => 'assets/images/logo-dark.svg',
            'rules' => ['nullable', 'image', 'max:1024'],
        ],
        'app_logo_light' => [
            'default' => 'assets/images/logo-light.svg',
            'rules' => ['nullable', 'image', 'max:1024'],
        ],
        'app_name' => [
            'default' => [
                'en' => 'Cash Afandy',
                'ar' => 'كاش أفندى',
            ],
            'rules' => [
                'app_name' => ['required', 'array'],
                'app_name.*' => ['required', 'string'],
            ],
        ],
        'website_locales' => [
            'default' => ['en', 'ar'],
            'rules' => ['required', 'array', 'min:1'],
        ],
        'dashboard_locales' => [
            'default' => ['en', 'ar'],
            'rules' => ['required', 'array', 'min:1'],
        ],
        'page_loader_enabled' => [
            'default' => false,
        ],
        'service_worker_enabled' => [
            'default' => true,
        ],
        'facebook_pixel_id' => [
            'default' => '',
        ],
        'google_analytics_property_id' => [
            'default' => '',
        ],
        'cloudflare_turnstile_site_key' => [
            'default' => '',
        ],
        'cloudflare_turnstile_secret_key' => [
            'default' => '',
        ],
        'head_code' => [
            'default' => '',
        ],
        'body_code' => [
            'default' => '',
        ],
        'dashboard_sidebar_theme' => [
            'default' => 'inherit',
        ],
        'theme' => [
            'default' => [
                'primary' => 'red',
                'base' => 'default',
                'font' => 'serif',
                'radius' => 1,
            ],
        ],
    ],
];
