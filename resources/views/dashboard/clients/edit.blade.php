<x-layouts::dashboard>
    <x-form-card resource="clients" :entry="$client" :data="['categories' => $categories, 'countries' => $countries]" />
</x-layouts::dashboard>
