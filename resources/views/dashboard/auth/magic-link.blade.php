<x-layouts::dashboard.auth :title="__('Login with Magic Link')">
    <x-form class="card card-md" :action="route('dashboard.magic-link.store')" method="POST">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">
                {{ __('Login with Magic Link') }}
            </h2>

            <p class="text-muted mb-4">
                {{ __('Enter your email address and we will send you a login link.') }}
            </p>

            <div class="mb-3">
                <x-input type="email" name="email" :title="__('Email address')" value="{{ old('email') }}"
                    placeholder="your@email.com" validation="required|email" />
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">{{ __('Send Magic Link') }}</button>
            </div>

            <p class="text-muted text-center mt-3">
                <a href="{{ route('dashboard.login') }}">{{ __('Back to login') }}</a>
            </p>
        </div>
    </x-form>
</x-layouts::dashboard.auth>
