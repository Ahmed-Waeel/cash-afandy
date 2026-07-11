@if ($file)
    <a href="{{ $file }}" {{ $attributes }}>
        <small class="form-hint mt-1">{{ __('Click here to view the current file.') }}</small>
    </a>
@endif
