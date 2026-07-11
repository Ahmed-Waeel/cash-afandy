<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $direction }}">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{!! $title !!}</title>

    <link rel="stylesheet" href="{{ public_path('/assets/css/pdf.css') }}" />

    @stack('styles')
</head>

<body {{ $attributes->merge(['dir' => $direction]) }}>
    <div class="pb-4 text-center">
        <img src="{{ setting('app_logo_light') }}" />
    </div>

    {{ $slot }}

    <htmlpagefooter name="page-footer">
        <div class="pb-4 text-center">
            {{ __('Page {PAGENO} of {nb}') }}
        </div>
    </htmlpagefooter>
</body>

</html>
