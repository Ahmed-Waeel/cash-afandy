<div id="{{ $id }}" init="apex-chart" {{ $attributes->class(['w-100']) }}></div>

@pushOnce('plugins-scripts', 'apexcharts-scripts')
    <script src="{{ hashed_asset('/vendor/apexcharts/apexcharts.min.js') }}"></script>
@endPushOnce
