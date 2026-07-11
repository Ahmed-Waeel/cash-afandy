@props([
    'code' => 'eg',
    'size' => 'md',
])

@pushOnce('plugins-styles', 'tabler-flags-styles')
    <link rel="stylesheet" href="{{ hashed_asset('/vendor/tabler/css/tabler-flags.min.css') }}" />
@endPushOnce

<span {{ $attributes->class(['flag', "flag-$size", "flag-country-$code"]) }}></span>
