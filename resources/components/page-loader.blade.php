<div class="page page-loader">
    <div class="container container-slim text-center py-4 my-auto">
        <div><x-logo class="mb-4" :lazy="false" /></div>
        <div class="spinner-border"></div>
    </div>
</div>

@push('scripts')
    <script>
        $(window).on('load', () => $('.page-loader').fadeOut());
    </script>
@endpush
