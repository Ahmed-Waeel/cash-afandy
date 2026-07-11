@props([
    'error' => '500',
    'class' => 'd-flex flex-column',
])

{{-- Check if the current request belongs to the dashboard scope --}}
@php($isDashboard = is_dashboard_request() && current_admin() !== null)

<x-layouts::scaffold :title="$error" class="{{ $class }}">
    @if ($isDashboard)
        @themer('dashboard-theme')
    @else
        @themer('website-theme')
    @endif

    <div class="page">
        <div class="container container-tight py-4 my-auto">
            <div class="empty">
                <div class="empty-header">
                    {{ $error }}
                </div>

                <p class="empty-title">
                    @yield('title')
                </p>

                @hasSection('subtitle')
                    <p class="empty-subtitle text-muted">
                        @yield('subtitle')
                    </p>
                @endif

                @hasSection('action')
                    <div class="empty-action">
                        @yield('action')
                    </div>
                @else
                    <div class="empty-action">
                        <a href="{{ $isDashboard ? route('dashboard.index') : route('website.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left me-3"></i>
                            {{ __('Back to Home') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::scaffold>
