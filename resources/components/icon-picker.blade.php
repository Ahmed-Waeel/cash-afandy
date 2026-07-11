@pushOnce('templates')
    <template iconpicker-template>
        <input type="text" class="form-control" placeholder="{{ __('Search for an icon') }}..." iconpicker-search />

        <div iconpicker-list>
            <p iconpicker-empty>{{ __('No icons found.') }}</p>
            <p iconpicker-loading><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></p>
        </div>
    </template>
@endPushOnce

@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<div class="row g-2 w-100" iconpicker-wrapper>
    <div class="col input-icon">
        <span class="input-icon-addon">
            <i class="icon icon-sm {{ $attributes->get('value') }}" iconpicker-preview></i>
        </span>

        <input type="text" id="{{ $id }}" autocomplete="off"
            {{ $attributes->class(['form-control'])->merge(['init' => 'icon-picker']) }} />
    </div>

    <div class="col-auto">
        <button type="button" class="btn btn-icon" tabindex="-1" iconpicker-picker>
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@pushOnce('plugins-scripts', 'icon-picker-scripts')
    <script src="{{ hashed_asset('assets/plugins/redot-icon-picker.js') }}"></script>
@endPushOnce
