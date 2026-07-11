@pushOnce('plugins-styles', 'coloris-styles')
    <link rel="stylesheet" href="{{ hashed_asset('/vendor/coloris/coloris.min.css') }}">
@endPushOnce

@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<input type="text" id="{{ $id }}" {{ $attributes->class(['form-control'])->merge(['init' => 'coloris']) }} />

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@pushOnce('plugins-scripts', 'coloris-scripts')
    <script src="{{ hashed_asset('/vendor/coloris/coloris.min.js') }}"></script>
@endPushOnce
