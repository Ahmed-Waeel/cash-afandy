<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.users.create')" class="mb-3" />
    <livewire:datatables.users />
</x-layouts::dashboard>
