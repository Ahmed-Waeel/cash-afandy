<x-layouts::error :error="$exception->getStatusCode()">
    @section('title', __($exception->getMessage() ?: 'Something went wrong'))
    @section('subtitle', __('If you are the application owner check the logs for more information'))
</x-layouts::error>
