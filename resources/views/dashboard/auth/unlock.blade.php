<x-layouts::dashboard.auth :title="__('Login to your account')">
    <x-form class="card card-md" :action="route('dashboard.unlock.store')" method="POST">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="h2 mb-2">
                    {{ __('Account Locked') }}
                </h2>

                <p class="text-muted m-0">
                    {{ __('Please enter your password to unlock your session') }}
                </p>

                <a class="cursor-pointer" onclick="$('#logout-form').submit();">
                    {{ __('Or sign in as a different user') }}
                </a>
            </div>

            <div class="d-flex justify-content-center my-5">
                <x-avatar size="xl" :name="$user->name" :image="$user->profile_picture" />
            </div>

            <div class="mb-3">
                <x-input type="password" name="password" :placeholder="__('Password')" validation="required" />
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-unlock-alt me-2"></i>
                    {{ __('Unlock') }}
                </button>
            </div>
        </div>
    </x-form>

    <x-form id="logout-form" :action="route('dashboard.logout')" method="POST" class="d-none" disable-validation />
</x-layouts::dashboard.auth>
