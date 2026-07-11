<x-layouts::dashboard inline>
    @if ($token->value !== $token->original_translation)
        <x-alert type="info">
            <p>{{ __('This token has been modified. The original translation was') }}:</p>
            <strong>"{{ $token->original_translation }}"</strong>
        </x-alert>
    @endif

    <x-form-card
        resource="languages.tokens"
        :entry="$token"
        :back="false"
        :route-params="[$language]"
    />
</x-layouts::dashboard>
