@if ($title && $floating === false)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<div id="{{ $id }}-container">
    <div class="d-flex align-items-start gap-2">
        @if ($floating)
            <div class="form-floating">
                <select id="{{ $id }}" validation-container="#{{ $id }}-container" {{ $attributes->class(['form-select']) }}>
                    @foreach ($options as $key => $label)
                        <option value="{{ $key }}" @selected(in_array($key, $value))>{{ $label }}</option>
                    @endforeach

                    {{ $slot }}
                </select>

                @if ($title)
                    <x-label :title="$title" :for="$id" :required="$required" />
                @endif
            </div>
        @else
            <select id="{{ $id }}" validation-container="#{{ $id }}-container" {{ $attributes }}>
                @foreach ($options as $key => $label)
                    <option value="{{ $key }}" @selected(in_array($key, $value))>{{ $label }}</option>
                @endforeach

                {{ $slot }}
            </select>
        @endif

        @if ($create)
            <a href="{{ route($create, $createParams) }}" class="btn btn-icon" data-fancybox data-type="iframe">
                <i class="fas fa-plus"></i>
            </a>
        @endif
    </div>
</div>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@if ($tom)
    @pushOnce('plugins-styles', 'tom-select-styles')
        <link rel="stylesheet" href="{{ hashed_asset('/vendor/tom-select/tom-select.min.css') }}">
    @endPushOnce

    @pushOnce('plugins-scripts', 'tom-select-scripts')
        <script src="{{ hashed_asset('/vendor/tom-select/tom-select.complete.min.js') }}"></script>
    @endPushOnce
@endif
