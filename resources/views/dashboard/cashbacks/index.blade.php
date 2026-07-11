<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.cashbacks.create')" class="mb-3" />
    <livewire:datatables.cashbacks />
</x-layouts::dashboard>
