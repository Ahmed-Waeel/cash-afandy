<x-form id="logout" :action="route('website.logout')" method="POST" class="d-none" disable-validation />

<nav class="navbar navbar-expand-lg d-print-none">
    <div class="container">
        <a class="navbar-brand my-2" href="{{ route('website.index') }}">
            <x-logo />
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbar">
            <ul class="navbar-nav ms-auto">
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

                @if (count(setting('website_locales')) > 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <span class="nav-link-icon"><i class="fa fa-language"></i></span>
                            <span class="nav-link-title">{{ config('app.locales.' . app()->getLocale()) }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach (setting('website_locales') as $locale)
                                <a class="dropdown-item" href="{{ url()->current() }}?locale={{ $locale }}">
                                    <span class="nav-link-title">{{ config('app.locales.' . $locale) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <span class="nav-link-icon"><i class="fa fa-user"></i></span>
                        <span class="nav-link-title">
                            {{ auth('users')->check() ? current_user()->full_name : __('Account') }}
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        @auth('users')
                            <a href="{{ route('website.profile.edit') }}" class="dropdown-item">
                                <span class="dropdown-item-title">{{ __('Profile') }}</span>
                            </a>

                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); $('#logout').submit()">
                                <span class="dropdown-item-title">{{ __('Logout') }}</span>
                            </a>
                        @else
                            <a href="{{ route('website.login') }}" class="dropdown-item">
                                <span class="dropdown-item-title">{{ __('Login') }}</span>
                            </a>

                            <a href="{{ route('website.register') }}" class="dropdown-item">
                                <span class="dropdown-item-title">{{ __('Register') }}</span>
                            </a>
                        @endauth
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
