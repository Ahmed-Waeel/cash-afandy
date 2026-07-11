<x-layouts::dashboard.auth :title="__('Reset password')">
    <x-form class="card card-md" :action="route('dashboard.password.store')" method="POST">
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="card-body">
            <h2 class="card-title text-center mb-4">
                {{ __('Reset password') }}
            </h2>

            <p class="text-muted mb-4">
                {{ __('Make sure to use a strong password to keep your account secure.') }}
            </p>

            <div class="mb-3">
                <x-input type="email" name="email" :title="__('Email address')" value="{{ old('email', $request->email) }}"
                    placeholder="your@email.com" validation="required|email" />
            </div>

            <div class="mb-3">
                <x-input type="password" name="password" :title="__('Password')" placeholder="{{ __('Password') }}"
                    validation="required" />
            </div>

            <div class="mb-3">
                <x-input type="password" name="password_confirmation" :title="__('Confirm Password')"
                    placeholder="{{ __('Confirm Password') }}" validation="required" />
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">{{ __('Reset password') }}</button>
            </div>
        </div>
    </x-form>
</x-layouts::dashboard.auth>
