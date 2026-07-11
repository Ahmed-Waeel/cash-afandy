<div class="row">
    <div class="col-12 col-md-2 mb-3">
        <x-select name="locale" :title="__('Locale')" :options="collect(config('app.locales'))->only(setting('website_locales'))->all()" :value="old('locale', $entry?->locale ?? app()->getLocale())" validation="required" />
    </div>

    <div class="col-12 col-md-10 mb-3">
        <x-input name="title" :title="__('Title')" :value="old('title', $entry?->title)" validation="required" />
    </div>
</div>

<div class="mb-3">
    <x-uploader name="image" :title="__('Image')" accept="image/*" :value="old('image', $entry?->image)" directory="sliders"
        uploader-multiple="false" uploader-return-type="url" />
</div>

<div class="mb-3">
    <x-rich-editor name="description" :title="__('Description')" :value="old('description', $entry?->description)" />
</div>

<div class="row">
    <div class="col-12 col-md-4 mb-3">
        <x-select name="background_size" :title="__('Image Fit')" :options="[
            'cover' => __('Cover'),
            'contain' => __('Contain'),
        ]" :value="old('background_size', $entry?->background_size ?? 'cover')"
            validation="required" />
    </div>

    <div class="col-12 col-md-4 mb-3">
        <x-color-picker name="foreground" :title="__('Text Color')" :value="old('foreground', $entry?->foreground ?? '#ffffff')" />
    </div>

    <div class="col-12 col-md-4 mb-3">
        <x-color-picker name="background" :title="__('Background Color')" :value="old('background', $entry?->background ?? '#00000080')" />
    </div>
</div>

<div class="mb-3">
    <x-repeater name="buttons" :title="__('Buttons')" :value="old('buttons', $entry?->buttons ?? [])">
        <x-repeater-card>
            <div class="row">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <x-select name="type" :title="__('Type')" validation="required" :options="[
                        'primary' => __('Primary'),
                        'secondary' => __('Secondary'),
                        'success' => __('Success'),
                        'danger' => __('Danger'),
                        'warning' => __('Warning'),
                        'info' => __('Info'),
                    ]" />
                </div>

                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <x-input name="label" :title="__('Label')" validation="required" />
                </div>

                <div class="col-12 col-md-4">
                    <x-input type="url" name="url" :title="__('Url')" validation="required|url" />
                </div>
            </div>
        </x-repeater-card>
    </x-repeater>
</div>

<div class="mb-3">
    <x-toggle name="active" :title="__('Active')" :value="old('active', $entry?->active ?? true)" :on="__('Yes')" :off="__('No')" />
</div>
