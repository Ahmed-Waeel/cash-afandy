<x-layouts::website.auth :title="__('Enter Code')">
    <x-status />

    <x-form class="card card-md" :action="route('website.magic-link-code.store')" method="POST">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="h2 mb-2">
                    {{ __('Enter Code') }}
                </h2>

                <p class="text-muted">
                    {{ __('We sent a code to :email. Enter it below or click the link in the email.', ['email' => $email]) }}
                </p>
            </div>

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <x-input type="text" name="code" :title="__('Code')" :placeholder="__('Enter 6-digit code')"
                    validation="required" maxlength="6" autocomplete="one-time-code" inputmode="numeric" />
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-brand w-100">{{ __('Verify Code') }}</button>
            </div>

            <p class="text-muted text-center mt-3 mb-0">
                <a href="{{ route('website.magic-link.create') }}">{{ __('Didn\'t receive the email? Try again') }}</a>
            </p>
        </div>
    </x-form>
</x-layouts::website.auth>
