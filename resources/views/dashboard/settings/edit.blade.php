<x-layouts::dashboard>
    <nav class="nav nav-segmented nav-3 mb-2 text-on-active" role="tablist">
        @foreach ($sections as $key => $value)
            <a href="#{{ $key }}" data-bs-toggle="tab" @class(['nav-link', 'active' => $loop->first])>
                <span class="nav-link-icon"><i class="{{ $value['icon'] }}"></i></span>
                <span class="nav-link-title">{{ $value['title'] }}</span>
            </a>
        @endforeach
    </nav>

    <x-form class="card" :action="route('dashboard.settings.update')" method="PUT">
        <div class="card-body tab-content">
            @foreach ($sections as $key => $value)
                <div @class(['tab-pane fade', 'show active' => $loop->first]) id="{{ $key }}">
                    @include('dashboard.settings.partials.' . $key)
                </div>
            @endforeach
        </div>

        <div class="card-footer">
            <div class="btn-list justify-content-end">
                <button type="reset" class="btn">{{ __('Reset') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </div>
    </x-form>
</x-layouts::dashboard>
