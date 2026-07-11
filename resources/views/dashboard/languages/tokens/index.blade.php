<x-layouts::dashboard>
    <x-page-header :title="__('Language Tokens')" :pretitle="$language->name" class="mb-3">
        <div class="dropdown">
            <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-2"></i>
                {{ __('Actions') }}
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item" action-confirm href="{{ route('dashboard.languages.tokens.publish', ['language' => $language]) }}">
                    <span class="dropdown-item-icon"><i class="fas fa-upload me-2"></i></span>
                    <span class="dropdown-item-title">{{ __('Publish Tokens') }}</span>
                </a>

                <a class="dropdown-item" action-confirm href="{{ route('dashboard.languages.tokens.revert', ['language' => $language]) }}">
                    <span class="dropdown-item-icon"><i class="fas fa-history me-2"></i></span>
                    <span class="dropdown-item-title">{{ __('Revert Tokens') }}</span>
                </a>

                <a class="dropdown-item" action-confirm href="{{ route('dashboard.languages.tokens.extract', ['language' => $language]) }}">
                    <span class="dropdown-item-icon"><i class="fas fa-file-export me-2"></i></span>
                    <span class="dropdown-item-title">{{ __('Extract Tokens') }}</span>
                </a>
            </div>
        </div>
    </x-page-header>

    @push('scripts')
        <script>
            $('[action-confirm]').on('click', function (event) {
                event.preventDefault();

                warnBeforeAction(() => {
                    location.href = $(this).attr('href');
                });
            });
        </script>
    @endpush

    <x-alert type="info" :icon="false">
        <ul class="m-0">
            <li>
                {{ __('There\'s about :count token(s) that need to be published.', ['count' => $language->tokens()->unpublished()->count()]) }}
            </li>
            <li>
                {{ __('There\'s about :count token(s) that have been modified.', ['count' => $language->tokens()->modified()->count()]) }}
            </li>
        </ul>
    </x-alert>

    <livewire:datatables.language-tokens :language="$language" />
</x-layouts::dashboard>
