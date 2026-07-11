<x-layouts::error error="403">
    @section('title', __('Forbidden'))
    @section('subtitle', __($exception->getMessage() ?: 'You are not authorized to view this page'))
</x-layouts::error>
