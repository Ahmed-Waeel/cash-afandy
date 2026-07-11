@if ($title)
    <x-label :title="$title" :for="$id" :required="$required" />
@endif

<div class="rating-field" id="{{ $id }}" style="--star-size: {{ $size }};">
    @for ($i = $stars; $i > 0; $i--)
        <input type="radio" name="{{ $name }}" id="{{ "$id-$i" }}" value="{{ $i }}"
            @checked($i == $value) />

        <label for="{{ "$id-$i" }}">
            <x-icon :icon="$icon" />
        </label>
    @endfor
</div>

@if ($hint)
    <x-hint class="mt-1">{{ $hint }}</x-hint>
@endif
