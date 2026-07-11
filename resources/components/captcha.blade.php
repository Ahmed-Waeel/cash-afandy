@if ($title)
    <x-label :title="$title" :for="$id" :required="true" />
@endif

@pushOnce('meta', 'cloudflare-turnstile-meta')
    <meta name="cloudflare-turnstile-site-key" content="{{ setting('cloudflare_turnstile_site_key') }}">
@endPushOnce

<div id="{{ $id }}" {{ $attributes }}>
    <input type="hidden" name="{{ $name }}" validation="required">
</div>

@pushOnce('plugins-scripts', 'cloudflare-turnstile-scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit"></script>
@endPushOnce
