<div class="mb-3">
    <x-radios-colored name="theme[primary]" :title="__('Color scheme')" :value="setting('theme.primary')" :options="[
        'blue' => 'blue',
        'azure' => 'azure',
        'indigo' => 'indigo',
        'purple' => 'purple',
        'pink' => 'pink',
        'red' => 'red',
        'orange' => 'orange',
        'yellow' => 'yellow',
        'lime' => 'lime',
        'green' => 'green',
        'teal' => 'teal',
        'cyan' => 'cyan',
        'black' => 'black',
    ]" />
</div>

<div class="mb-3">
    <x-radios name="theme[base]" :title="__('Theme Base')" :value="setting('theme.base')" :inline="true" :options="[
        'default' => __('Default'),
        'slate' => __('Slate'),
        'gray' => __('Gray'),
        'zinc' => __('Zinc'),
        'neutral' => __('Neutral'),
        'stone' => __('Stone'),
        'pink' => __('Pink'),
    ]" />
</div>

<div class="mb-3">
    <x-radios name="theme[font]" :title="__('Font Family')" :value="setting('theme.font')" :inline="true" :options="[
        'sans-serif' => __('Sans Serif'),
        'serif' => __('Serif'),
        'monospace' => __('Monospace'),
        'comic' => __('Comic'),
    ]" />
</div>

<div class="mb-3">
    <x-radios name="theme[radius]" :title="__('Corner Radius')" :value="setting('theme.radius')" :inline="true" :options="[
        '0' => __('None'),
        '0.5' => __('Small'),
        '1' => __('Medium'),
        '1.5' => __('Large'),
        '2' => __('Extra Large'),
    ]" />
</div>

<div class="mb-3">
    <x-radios name="dashboard_sidebar_theme" :title="__('Sidebar theme')" :value="setting('dashboard_sidebar_theme', 'inherit')" :inline="true"
        :options="[
            'inherit' => __('Inherit'),
            'dark' => __('Force dark'),
        ]" />
</div>

@push('scripts')
    <script>
        $('[name^="theme"]').on('change', function () {
            if (this.checked === false) return;

            const key = this.name.replace('theme[', '').replace(']', '');
            document.documentElement.setAttribute(`data-bs-theme-${key}`, this.value);
        });

        $('[name="dashboard_sidebar_theme"]').on('change', function () {
            if (this.checked === false) return;

            const value = this.value;
            const theme = value === 'inherit' ? $('html').attr('data-bs-theme') : value;

            $('.dashboard-sidebar').attr('data-bs-theme', theme);
        });

        $('[type="reset"]').on('click', function () {
            setTimeout(() => $('[name^="theme"], [name="dashboard_sidebar_theme"]').trigger('change'), 0);
        });
    </script>
@endpush

<div class="mb-3">
    <x-toggle name="page_loader_enabled" :title="__('Page loader')" :value="setting('page_loader_enabled')" />
</div>
