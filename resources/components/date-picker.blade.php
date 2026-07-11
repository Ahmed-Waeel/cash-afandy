@pushOnce('plugins-styles', 'tempus-dominus-styles')
    <link rel="stylesheet" href="{{ hashed_asset('/vendor/tempus-dominus/tempus-dominus.min.css') }}">
@endPushOnce

@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<div class="col input-group input-group-flat">
    <input type="text" id="{{ $id }}" autocomplete="off"
        {{ $attributes->class(['form-control'])->merge(['init' => 'tempus-dominus']) }} />

    <span class="input-group-text">
        <x-icon icon="fa fa-calendar-alt" />
    </span>
</div>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@pushOnce('plugins-scripts', 'popper-scripts')
    <script src="{{ hashed_asset('/vendor/popper/popper.min.js') }}"></script>
@endPushOnce

@pushOnce('plugins-scripts', 'tempus-dominus-scripts')
    <script src="{{ hashed_asset('/vendor/tempus-dominus/tempus-dominus.min.js') }}"></script>
@endPushOnce
