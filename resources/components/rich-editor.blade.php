@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<x-textarea :value="$value" :id="$id" :autosize="false" init="tinymce"
    {{ $attributes->only(['name', 'validation']) }} />

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@pushOnce('plugins-scripts', 'tinymce-scripts')
    <script src="{{ hashed_asset('/vendor/tinymce/tinymce.min.js') }}"></script>
@endPushOnce
