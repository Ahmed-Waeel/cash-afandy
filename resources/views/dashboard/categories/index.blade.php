<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.categories.create')" class="mb-3" />
    <livewire:datatables.categories />
</x-layouts::dashboard>
