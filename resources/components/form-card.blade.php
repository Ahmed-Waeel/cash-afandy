<x-form :action="$action" :method="$method" {{ $attributes->class('card') }}>
    <div @class(['card-header', 'd-flex justify-content-between align-items-center' => isset($header)])>
        <p class="card-title">{{ $title }}</p>

        @isset($header)
            {{ $header }}
        @endisset
    </div>

    @if ($slot->isEmpty())
        <div class="card-body">
            @include("dashboard.$resource.partials.form", ['entry' => $entry])
        </div>
    @else
        {{ $slot }}
    @endif

    <div class="card-footer text-end">
        @if ($back)
            <a href="{{ back_or_route($back, $backParams) }}" class="btn">{{ __('Back') }}</a>
        @endif

        <button type="submit" class="btn btn-primary">{{ $submit }}</button>
    </div>
</x-form>
