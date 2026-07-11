<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.brokers.create')" class="mb-3" />
    <livewire:datatables.brokers />
</x-layouts::dashboard>
