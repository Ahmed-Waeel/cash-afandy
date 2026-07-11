<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.shortened-urls.create')" class="mb-3" />
    <livewire:datatables.shortened-urls />
</x-layouts::dashboard>
