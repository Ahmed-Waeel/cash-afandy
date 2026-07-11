@pushIf(setting('google_analytics_property_id'), 'scripts')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_property_id') }}"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', '{{ setting('google_analytics_property_id') }}');
    </script>
@endPushIf
