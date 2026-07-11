<div id="{{ $id }}" translatable>
    <div class="tab-content">
        @foreach ($localesConfig as $locale => $config)
            <div class="tab-pane{{ $loop->first ? ' active' : '' }}" id="{{ $config['id'] . '-content' }}" role="tabpanel">
                <x-dynamic-component :component="$component" :name="$config['name']" :value="$config['value']" :validation="$config['validation']"
                    {{ $attributes }} />
            </div>
        @endforeach
    </div>

    @if (count($locales) > 1)
        <ul class="list-unstyled d-flex gap-2 mt-2 mb-0" role="tablist">
            @foreach ($localesConfig as $locale => $config)
                <li role="presentation">
                    <a class="btn btn-sm{{ $loop->first ? ' active' : '' }}" id="{{ $config['id'] }}" data-bs-toggle="tab"
                        href="#{{ $config['id'] . '-content' }}" locale="{{ $locale }}" role="tab"
                        translatable-tab>
                        <span>{{ $locale }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
