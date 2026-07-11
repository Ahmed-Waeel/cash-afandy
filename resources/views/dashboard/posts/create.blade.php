<x-layouts::dashboard>
    <x-form-card resource="posts" :data="['categories' => $categories, 'tags' => $tags, 'locales' => $locales]" />
</x-layouts::dashboard>
