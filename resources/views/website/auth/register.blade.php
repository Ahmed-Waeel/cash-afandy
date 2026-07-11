<x-layouts::website.auth :title="__('Create new account')">
    <x-status />

    <x-form class="card card-md" :action="route('website.register.store')" method="POST">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="h2 mb-2">
                    {{ __('Create new account') }}
                </h2>

                <p class="text-muted">
                    {{ __('It\'s free and only takes less than a minute') }}
                </p>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <x-input type="text" name="first_name" :title="__('First name')" value="{{ old('first_name') }}"
                        :placeholder="__('First name')" validation="required" />
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <x-input type="text" name="last_name" :title="__('Last name')" value="{{ old('last_name') }}"
                        :placeholder="__('Last name')" validation="required" />
                </div>
            </div>

            <div class="mb-3">
                <x-input type="email" name="email" :title="__('Email address')" value="{{ old('email') }}"
                    placeholder="your@email.com" validation="required|email" />
            </div>

            <div class="mb-3">
                <x-input type="password" name="password" :title="__('Password')" :placeholder="__('Password')" validation="required" />
            </div>

            <div class="mb-3">
                <x-input type="password" name="password_confirmation" :title="__('Confirm Password')" :placeholder="__('Confirm Password')"
                    validation="required" />
            </div>

            @if (setting('cloudflare_turnstile_site_key'))
                <x-captcha :title="__('Captcha')" name="captcha" />
            @endif

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">{{ __('Sign up') }}</button>
            </div>

            <p class="text-muted text-center mt-3">
                {{ __('Already have an account?') }}
                <a href="{{ route('website.login') }}">{{ __('Login') }}</a>
            </p>
        </div>
    </x-form>
</x-layouts::website.auth>
