<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.admins.create')" class="mb-3" />
    <livewire:datatables.admins />
</x-layouts::dashboard>
