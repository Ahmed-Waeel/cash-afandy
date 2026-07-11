@props(['item'])

@php
    $badge = $item->badge ? call_user_func($item->badge) : null;
@endphp

<li @class(['nav-item', 'active' => $item->active])>
    <a class="nav-link" href="{{ $item->url }}" @if ($item->external) target="_blank" @endif>
        @if (isset($item->icon))
            <span class="nav-link-icon">
                <x-icon :icon="$item->icon" />
            </span>
        @endif

        <span class="nav-link-title text-truncate me-2" title="{{ $item->title }}">
            {{ $item->title }}
        </span>

        @if ($badge)
            <span class="badge badge-sm bg-red-lt ms-auto">
                {{ $badge }}
            </span>
        @endif
    </a>
</li>
