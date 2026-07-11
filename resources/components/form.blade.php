<form id="{{ $id }}" action="{{ $action }}" method="{{ $formMethod }}" enctype="{{ $enctype }}"
    {{ $attributes }}>
    @csrf

    {{-- Method spoofing --}}
    @if (in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    {{-- Identifier to know which form is being submitted --}}
    <input type="hidden" name="_form" value="{{ $identifier }}" />

    {{ $slot }}
</form>
