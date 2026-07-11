<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <x-input type="url" name="url" :title="__('Url')" :value="old('url', $entry?->url)" validation="required|url" :readonly="$entry !== null" />
    </div>

    <div class="col-12 col-md-6 mb-3">
        <x-input name="slug" :title="__('Slug')" :value="old('slug', $entry?->slug ?? \Illuminate\Support\Str::random(10))" :prepend="route('website.shortened-urls.show') . '/'"
            validation="nullable|alpha_dash|max:120" :readonly="$entry !== null" />
    </div>
</div>

<div class="mb-3">
    <x-input name="title" :title="__('Title')" :value="old('title', $entry?->title)" validation="nullable|max:120" />
</div>

<div class="mb-3">
    <x-select name="tags[]" :title="__('Tags')" :options="$tags" :value="old('tags', $entry?->tags)" tags multiple />
</div>
