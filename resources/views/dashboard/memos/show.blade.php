<x-layouts::dashboard inline>
    <div class="card">
        <div class="card-header d-flex flex-column align-items-start">
            <p class="card-title">
                @if ($memo->icon)
                    <i class="{{ $memo->icon }} me-2"></i>
                @endif

                {{ $memo->title }}
            </p>

            @if ($memo->date)
                <h5 class="card-subtitle text-muted">
                    {{ $memo->date->translatedFormat('l, d F Y') }}
                </h5>
            @endif
        </div>

        <div class="card-body">
            {!! $memo->content ?: no_content() !!}
        </div>

        @if ($memo->attachments)
            <div class="card-footer">
                <x-attachments :attachments="$memo->attachments" />
            </div>
        @endif
    </div>
</x-layouts::dashboard>
