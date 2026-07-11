<div role="alert" {{ $attributes }}>
    @if ($icon)
        <x-icon :icon="$icon" class="alert-icon icon" />
    @endif

    <div>
        @if ($description)
            <h4 class="alert-title">{{ $title }}</h4>
            <div class="text-secondary">{{ $description }}</div>
        @else
            {{ $title ?: $slot }}
        @endif
    </div>

    @if ($dismissible)
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    @endif
</div>
