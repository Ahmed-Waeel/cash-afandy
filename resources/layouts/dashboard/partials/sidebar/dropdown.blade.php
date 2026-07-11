@props(['item'])

<li @class(['nav-item', 'dropdown', 'active' => $item->active])>
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button">
        @if (isset($item->icon))
            <span class="nav-link-icon"><i class="{{ $item->icon }}"></i></span>
        @endif

        {{ $item->title }}
    </a>

    <div @class(['dropdown-menu', 'show' => $item->active])>
        @foreach ($item->children as $child)
            @include('layouts.dashboard.partials.sidebar.dropdown-item', ['item' => $child])
        @endforeach
    </div>
</li>
