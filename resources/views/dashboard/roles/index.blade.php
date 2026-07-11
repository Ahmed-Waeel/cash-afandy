<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.roles.create')" class="mb-3" />
    <livewire:datatables.roles />
</x-layouts::dashboard>
