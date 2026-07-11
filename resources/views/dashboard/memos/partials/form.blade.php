<div class="mb-3">
    <x-input name="title" :title="__('Title')" :value="old('title', $entry?->title)" validation="required" />
</div>

<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <x-icon-picker name="icon" :title="__('Icon')" :value="old('icon', $entry?->icon ?? 'far fa-note-sticky')" />
    </div>

    <div class="col-12 col-md-6 mb-3">
        <x-date-picker name="date" :title="__('Date')" :value="old('date', $entry?->date ?? now())" datetime />
    </div>
</div>

<div class="mb-3">
    <x-rich-editor name="content" :title="__('Content')" :value="old('content', $entry?->content)" />
</div>

<div class="mb-3">
    <x-uploader name="attachments" :title="__('Attachments')" :value="old('attachments', $entry?->attachments)" directory="memos" />
</div>
