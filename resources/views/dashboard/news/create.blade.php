<x-layouts::dashboard>
    <x-form-card resource="news" :data="['categories' => $categories, 'tags' => $tags, 'locales' => $locales]" />
</x-layouts::dashboard>
