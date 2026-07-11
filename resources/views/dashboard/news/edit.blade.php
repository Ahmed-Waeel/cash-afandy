<x-layouts::dashboard>
    <x-form-card resource="news" :entry="$news" :data="['categories' => $categories, 'tags' => $tags, 'locales' => $locales]" />
</x-layouts::dashboard>
