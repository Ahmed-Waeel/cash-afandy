@php
    $selected = old('permissions', $entry ? $entry->permissions->pluck('name')->toArray() : []);
@endphp

<div class="d-flex align-items-start gap-2">
    <x-input name="name" :value="old('name', $entry?->name)" :placeholder="__('Name')" validation="required" />
</div>

<div class="row mt-3">
    @foreach ($permissions as $key => $values)
        @php
            $title = Str::title(str_replace(['.', '-'], ' ', $key));
            $options = collect($values)
                ->mapWithKeys(fn($p) => [$p->name => Str::title(Arr::last(explode('.', $p->name)))])
                ->all();
        @endphp

        <div class="col-12 col-md-6 col-xl-4 mb-3">
            <div class="card h-100" permissions-group>
                <div class="card-header d-flex align-items-center justify-content-between gap-3">
                    <p class="card-title">{{ $title }}</p>
                    <x-toggle class="form-check-reverse mb-0" :on="__('All')" :off="__('All')" permissions-toggle />
                </div>

                <div class="card-body">
                    <x-checkboxes name="permissions[]" :inline="true" :options="$options" :value="$selected" />
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
    <script>
        $('[permissions-group]').each((i, group) => {
            const $group = $(group);
            const $toggle = $group.find('[permissions-toggle]');
            const $boxes = $group.find('[name^="permissions"]');

            const sync = () => {
                const checked = $boxes.filter(':checked').length;
                $toggle.prop('checked', checked === $boxes.length);
                $toggle.prop('indeterminate', checked > 0 && checked < $boxes.length);
            };

            $toggle.on('change', () => $boxes.prop('checked', $toggle.is(':checked')));
            $boxes.on('change', sync);

            sync();
        });
    </script>
@endpush
