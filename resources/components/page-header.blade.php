@aware([
    'title' => __('Dashboard'),
])

@props([
    'title' => null,
    'pretitle' => __('Overview'),
    'create' => null,
])

<div {{ $attributes->class(['page-header d-print-none mt-0']) }}>
    <div class="row g-2 align-items-end">
        <div class="col">
            <div class="page-pretitle">{{ $pretitle }}</div>
            <h2 class="page-title">{{ $title }}</h2>
        </div>

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                @if ($create && url_allowed($create))
                    <a href="{{ $create }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>

                        {{ __('Create') }}
                    </a>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
