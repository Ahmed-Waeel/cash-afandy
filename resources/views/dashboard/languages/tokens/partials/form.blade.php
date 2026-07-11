<div class="mb-3">
    <x-input :title="__('Translation Key')" :value="$entry->key" disabled />
</div>

<div class="mb-3">
    <x-input :title="__('Current Translation')" :value="$entry->value" disabled />
</div>

<div class="mb-3">
    <x-input :title="__('New Translation')" name="value" :value="old('value', $entry->value)" />
</div>
