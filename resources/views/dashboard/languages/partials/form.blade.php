@if (! $entry)
    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <x-input name="name" :title="__('Language Name')" :value="old('name')" validation="required" />
        </div>

        <div class="col-12 col-md-6 mb-3">
            <x-input name="code" :title="__('Language Code')" :value="old('code')" validation="required" />
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <x-select name="source" :title="__('Source')" :options="config('app.locales')" :value="old('source', config('app.fallback_locale'))"
                validation="required" />
        </div>

        <div class="col-12 col-md-6 mb-3">
            <x-select name="direction" :title="__('Direction')" :value="old('direction', 'ltr')" validation="required"
                :options="['ltr' => __('Left to Right'), 'rtl' => __('Right to Left')]" />
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <x-input name="name" :title="__('Language Name')" :value="old('name', $entry->name)" validation="required" />
        </div>

        <div class="col-12 col-md-6 mb-3">
            <x-select name="direction" :title="__('Direction')" :value="old('direction', $entry->direction)" validation="required"
                :options="['ltr' => __('Left to Right'), 'rtl' => __('Right to Left')]" />
        </div>
    </div>
@endif
