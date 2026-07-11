<x-form id="logout-form" :action="route('dashboard.logout')" method="POST" class="d-none" disable-validation />

<nav class="navbar navbar-expand navbar-light d-print-none dashboard-navbar">
    <div class="container-fluid justify-content-between">
        <div class="flex-grow-1 me-2 dashboard-search">
            <div class="input-icon">
                <span class="input-icon-addon"><i class="fas fa-search"></i></span>
                <input type="search" class="form-control" id="search-pages" placeholder="{{ __('Search') }}" />
            </div>
        </div>

        <ul class="navbar-nav flex-row ms-auto">
            @if (config('redot.features.website.enabled'))
                <li class="nav-item">
                    <a href="{{ route('website.index') }}" target="_blank" class="nav-link">
                        <span class="nav-link-icon"><i class="fa fa-external-link-alt"></i></span>
                        <span class="nav-link-title">{{ __('Preview') }}</span>
                    </a>
                </li>
            @endif

            @if (count(setting('dashboard_locales')) > 1)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <span class="nav-link-icon"><i class="fa fa-language"></i></span>
                        <span class="nav-link-title">{{ config('app.locales.' . app()->getLocale()) }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach (setting('dashboard_locales') as $locale)
                            <a class="dropdown-item" href="{{ url()->current() }}?locale={{ $locale }}">
                                <span class="dropdown-item-title">{{ config('app.locales.' . $locale) }}</span>
                            </a>
                        @endforeach
                    </div>
                </li>
            @endif

            <li class="nav-item">
                <a href="#" data-theme="dark" class="nav-link hide-theme-dark">
                    <span class="nav-link-icon"><i class="fa fa-moon"></i></span>
                    <span class="nav-link-title">{{ __('Dark mode') }}</span>
                </a>

                <a href="#" data-theme="light" class="nav-link hide-theme-light">
                    <span class="nav-link-icon"><i class="fa fa-sun"></i></span>
                    <span class="nav-link-title">{{ __('Light mode') }}</span>
                </a>
            </li>

            <livewire:notifications />

            <li class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0 px-lg-2" data-bs-toggle="dropdown">
                    <x-avatar :name="$admin->name" :image="$admin->profile_picture" />

                    <div class="d-none d-xl-block ps-2">
                        <div>{{ $admin->name }}</div>
                        <div class="mt-1 small text-muted">
                            {{ \Illuminate\Support\Str::limit($admin->email, 20) }}</div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('dashboard.profile.edit') }}" class="dropdown-item">
                        <span class="dropdown-item-icon"><i class="fa fa-user"></i></span>
                        <span class="dropdown-item-title">{{ __('Profile') }}</span>
                    </a>

                    <x-form :action="route('dashboard.lock')" method="POST">
                        <button type="submit" class="dropdown-item">
                            <span class="dropdown-item-icon"><i class="fa fa-lock"></i></span>
                            <span class="dropdown-item-title">{{ __('Lock') }}</span>
                        </button>
                    </x-form>

                    <a class="dropdown-item cursor-pointer" onclick="$('#logout-form').submit();">
                        <span class="dropdown-item-icon"><i class="fa fa-sign-out-alt"></i></span>
                        <span class="dropdown-item-title">{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
