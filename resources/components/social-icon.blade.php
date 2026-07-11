@props([
    'social' => 'google',
    'size' => 'md',
])

@pushOnce('plugins-styles', 'tabler-socials-styles')
    <link rel="stylesheet" href="{{ hashed_asset('/vendor/tabler/css/tabler-socials.min.css') }}" />
@endPushOnce

<span {{ $attributes->class(['social', "social-$size", "social-app-$social"]) }}></span>
