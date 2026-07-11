@props(['item'])

@php
    $badge = $item->badge ? call_user_func($item->badge) : null;
@endphp

<a @class(['dropdown-item', 'active' => $item->active]) href="{{ $item->url }}">
    @if (isset($item->icon))
        <span class="nav-link-icon"><i class="{{ $item->icon }}"></i></span>
    @endif

    <span class="dropdown-item-title text-truncate" title="{{ $item->title }}">{{ $item->title }}</span>

    @if ($badge)
        <span class="badge badge-sm bg-red-lt ms-auto">
            {{ $badge }}
        </span>
    @endif
</a>
