<x-layouts::dashboard.auth :title="__('Login to your account')">
    <x-form class="card card-md" :action="route('dashboard.login.store')" method="POST">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="h2 mb-2">
                    {{ __('Login to your account') }}
                </h2>

                <p class="text-muted">
                    {{ __('Forgot your password?') }}
                    <a href="{{ route('dashboard.password.request') }}">{{ __('Reset password') }}</a>
                </p>
            </div>

            <div class="mb-3">
                <x-input type="email" name="email" :title="__('Email address')" value="{{ old('email') }}"
                    placeholder="your@email.com" validation="required|email" />
            </div>

            <div class="mb-3">
                <x-input type="password" name="password" :title="__('Password')" :placeholder="__('Password')" validation="required" />
            </div>

            <div class="mb-2">
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember">
                    <span class="form-check-label">{{ __('Remember me on this device') }}</span>
                </label>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">{{ __('Sign in') }}</button>
            </div>

            <div class="hr-text">{{ __('or') }}</div>

            <a href="{{ route('dashboard.magic-link.create') }}" class="btn w-100">
                {{ __('Login with Magic Link') }}
            </a>
        </div>
    </x-form>
</x-layouts::dashboard.auth>
