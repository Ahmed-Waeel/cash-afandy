@push('templates')
    <template repeater-template="{{ $id }}">
        {{ $slot }}
    </template>
@endpush

<div repeater-container>
    <input type="hidden" id="{{ $id }}" value="{{ $value }}"
        {{ $attributes->merge(['init' => 'repeater']) }}>

    <div repeater-wrapper>
        @if (isset($wrapper))
            {{ $wrapper }}
        @else
            <div class="repeater-toolbar">
                <div class="toolbar-title">
                    @if ($title)
                        <x-label :title="$title" :for="$id" :required="$required" />
                    @endif
                </div>

                <div class="btn-list gap-1">
                    <button type="button" class="btn bg-primary-lt btn-icon" action="insert">
                        <i class="fas fa-plus"></i>
                    </button>

                    <button type="button" class="btn bg-danger-lt btn-icon" action="clear">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <div repeater-list>
                @if (isset($empty))
                    <div {{ $empty->attributes->merge(['repeater-empty' => true]) }}>
                        {{ $empty }}
                    </div>
                @else
                    <x-empty repeater-empty icon="fas fa-list" :title="__('Add items to the list')" :subtitle="__('Click the plus button to add a new item')" />
                @endif
            </div>
        @endif
    </div>
</div>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif

@pushOnce('plugins-scripts', 'repeater-scripts')
    <script src="{{ hashed_asset('assets/plugins/redot-repeater.js') }}"></script>
@endPushOnce
