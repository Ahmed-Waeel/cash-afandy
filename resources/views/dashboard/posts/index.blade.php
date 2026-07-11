<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.posts.create')" class="mb-3" />
    <livewire:datatables.posts />
</x-layouts::dashboard>
