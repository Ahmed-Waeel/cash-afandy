<x-layouts::scaffold {{ $attributes->class(['d-flex flex-column']) }}>
    @themer('dashboard-theme')

    <div class="page">
        <div class="container container-tight py-4 my-auto">
            <div class="text-center mb-4">
                <a href="{{ route('dashboard.index') }}" class="navbar-brand">
                    <x-logo />
                </a>
            </div>

            <x-status />

            {{ $slot }}

            @if (count(setting('dashboard_locales')) > 1)
                <ul class="list-inline list-inline-dots mt-3 mb-0 text-center">
                    @foreach (setting('dashboard_locales') as $locale)
                        <li class="list-inline-item">
                            <a href="{{ url()->current() }}?locale={{ $locale }}"
                                class="link-secondary text-decoration-none">
                                {{ config('app.locales.' . $locale) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layouts::scaffold>
