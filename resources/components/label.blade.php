@props([
    'title' => null,
    'for' => null,
    'required' => false,
])

<label for="{{ $for }}" aria-label="{{ $title }}"
    {{ $attributes->class(['form-label', 'required' => $required]) }}>
    {!! $title !!}
</label>
