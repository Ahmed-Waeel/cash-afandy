@props(['items'])

<aside class="navbar navbar-vertical navbar-expand-lg d-print-none dashboard-sidebar"
    data-bs-theme="{{ setting('dashboard_sidebar_theme') }}" style="overflow: auto">
    <div class="container-fluid">
        <a class="navbar-brand my-lg-2 px-2" href="{{ route('dashboard.index') }}">
            <div class="navbar-brand-image d-flex align-items-center"><x-logo /></div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav">
                @foreach ($items as $item)
                    @if (isset($item->children) && count($item->children) > 0)
                        @include('layouts.dashboard.partials.sidebar.dropdown', ['item' => $item])
                    @else
                        @include('layouts.dashboard.partials.sidebar.item', ['item' => $item])
                    @endif
                @endforeach

                <li class="nav-item mt-auto mb-md-2">
                    <a class="nav-link cursor-pointer" onclick="$('#logout-form').submit();">
                        <span class="nav-link-icon"><i class="fa fa-sign-out-alt"></i></span>
                        <span class="nav-link-title">{{ __('Logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
