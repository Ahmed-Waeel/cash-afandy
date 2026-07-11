@props([
    'id' => uniqid('translatable-'),
    'locales' => array_keys(config('app.locales')),
])

<div id="{{ $id }}" {{ $attributes->class(['dropdown'])->merge(['translatable-switcher' => true]) }}>
    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-globe text-muted me-2"></i>
        <span>{{ __('Change locale') }}</span>
    </button>

    <div class="dropdown-menu">
        @foreach ($locales as $locale)
            <button type="button" class="dropdown-item" change-locale="{{ $locale }}">
                {{ config("app.locales.$locale") }}
                <small class="ms-1">({{ $locale }})</small>
            </button>
        @endforeach
    </div>
</div>

@pushOnce('scripts')
    <script>
        $('[change-locale]').on('click', function() {
            const locale = $(this).attr('change-locale');

            $(`[translatable-tab][locale="${locale}"]`).tab('show');
        });
    </script>
@endPushOnce
