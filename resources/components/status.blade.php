<x-alert :type="$status" :dismissible="true" {{ $attributes }}>
    @if (is_array(session($status)))
        <ul class="mb-0">
            @foreach (session($status) as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @else
        {{ session($status) }}
    @endif
</x-alert>
