@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<label {{ $attributes->class(['form-check form-switch']) }}>
    <input type="checkbox" id="{{ $id }}" @checked($value)
        {{ $attributes->class(['form-check-input']) }} />
    <span class="form-check-label form-check-label-on">{{ $on ?: __('Enabled') }}</span>
    <span class="form-check-label form-check-label-off">{{ $off ?: __('Disabled') }}</span>
</label>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif
