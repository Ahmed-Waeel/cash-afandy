<x-layouts::dashboard.auth :title="__('Forgot password')">
    <x-form class="card card-md" :action="route('dashboard.password.email')" method="POST">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">
                {{ __('Forgot password') }}
            </h2>

            <p class="text-muted mb-4">
                {{ __('Enter your email address and your reset password link will be emailed to you.') }}
            </p>

            <div class="mb-3">
                <x-input type="email" name="email" :title="__('Email address')" value="{{ old('email') }}"
                    placeholder="your@email.com" validation="required|email" />
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">{{ __('Send password reset link') }}</button>
            </div>
        </div>
    </x-form>
</x-layouts::dashboard.auth>
