@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<div uploader-container>
    <input type="hidden" id="{{ $id }}" value="{{ $value }}" {{ $attributes }} />

    <div uploader-wrapper>
        <div uploader-empty class="text-center py-4 text-muted">
            <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
            <p class="mb-0">{{ __('No files uploaded yet') }}</p>
            <small>{{ __('Click or drag and drop files here') }}</small>
        </div>

        <div uploader-list></div>
    </div>
</div>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@pushOnce('plugins-scripts', 'uploader-scripts')
    <script src="{{ hashed_asset('assets/plugins/redot-uploader.js') }}"></script>
@endPushOnce
