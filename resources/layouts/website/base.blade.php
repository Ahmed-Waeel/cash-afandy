<x-layouts::scaffold :title="$title" :inline="$inline" {{ $attributes->class($inline ? 'inline-layout' : 'standard-layout') }}>
    @themer('website-theme')

    {{-- Website styles aren't dark-mode ready yet, so force light regardless of system/localStorage preference --}}
    @push('pre-content')
        <script>document.documentElement.setAttribute('data-bs-theme', 'light');</script>
    @endpush

    @pushOnce('styles')
        <link rel="stylesheet" href="{{ hashed_asset('vendor/swiper/swiper-bundle.min.css') }}" />
        <link rel="stylesheet" href="{{ hashed_asset('vendor/tabler/css/tabler-flags.min.css') }}" />
        <link rel="stylesheet" href="{{ hashed_asset('assets/css/website.css') }}" />

        {!! setting('head_code') !!}
    @endPushOnce

    <main class="page">
        @if (! $inline)
            @include('layouts.website.partials.navbar')
        @endif

        <div class="page-wrapper">
            <div class="page-body">
                {{ $slot }}
            </div>
        </div>

        @if (! $inline)
            @include('layouts.website.partials.footer')
        @endif
    </main>

    @include('components.google-analytics')
    @include('components.facebook-pixel')

    @pushOnce('scripts')
        <script src="{{ hashed_asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ hashed_asset('assets/js/website.js') }}"></script>

        {!! setting('body_code') !!}
    @endPushOnce
</x-layouts::scaffold>
