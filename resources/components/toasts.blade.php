@pushOnce('plugins-scripts', 'redot-toasts-scripts')
    <script src="{{ hashed_asset('/assets/plugins/redot-toasts.js') }}"></script>

    <script>
        (() => {
            const config = @json($config);
            const messages = @json($messages);

            const toasts = new RedotToasts(config);

            // Render toasts flashed from the session.
            messages.forEach(({ type,  title, message, options = {} }) => {
                toasts.show(type, title, message, options);
            });
        })();
    </script>
@endPushOnce
