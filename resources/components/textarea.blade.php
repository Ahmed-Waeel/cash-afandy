@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<textarea id="{{ $id }}" {{ $attributes->class(['form-control']) }}>{!! $value ?: $slot !!}</textarea>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif
