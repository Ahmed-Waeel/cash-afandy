<x-layouts::dashboard>
    <x-page-header class="mb-3" :create="route('dashboard.static-pages.create')" />
    <livewire:datatables.static-pages />
</x-layouts::dashboard>
