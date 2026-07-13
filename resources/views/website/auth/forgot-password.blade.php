<x-layouts::website.auth :title="__('Forgot password')">
    <x-status />

    <x-form class="card card-md" :action="route('website.password.email')" method="POST">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="h2 mb-2">{{ __('Forgot password') }}</h2>

                <p class="text-muted">
                    {{ __('Enter your email address and your reset password link will be emailed to you.') }}
                </p>
            </div>

            <div class="mb-3">
                <x-input type="email" name="email" :title="__('Email address')" value="{{ old('email') }}"
                    placeholder="your@email.com" validation="required|email" />
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-brand w-100">{{ __('Send password reset link') }}</button>
            </div>

            <p class="text-muted text-center mt-3 mb-0">
                <a href="{{ route('website.login') }}">{{ __('Back to login') }}</a>
            </p>
        </div>
    </x-form>
</x-layouts::website.auth>
