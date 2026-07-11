<x-layouts::website.auth :title="__('Verify your email address')">
    <x-status />

    <x-form id="resend-verification" class="d-none" :action="route('website.verification.send')" method="POST" disable-validation />

    <div class="card card-md">
        <div class="card-body text-center">
            <h2 class="h1 mb-3">{{ __('Check your inbox') }}</h2>
            <p class="text-muted">
                {{ __('We have sent you an email with a link to verify your email address and complete your registration.') }}
            </p>

            <p class="text-muted mb-0">
                {{ __('If you did not receive the email') }},
                <a href="#" onclick="event.preventDefault(); $('#resend-verification').submit();">
                    {{ __('click here to request another') }}
                </a>
                .
            </p>
        </div>
    </div>
</x-layouts::website.auth>
