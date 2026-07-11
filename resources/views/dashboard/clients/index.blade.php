<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.clients.create')" class="mb-3" />
    <livewire:datatables.clients />
</x-layouts::dashboard>
