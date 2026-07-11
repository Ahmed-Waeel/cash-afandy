<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.languages.create')" class="mb-3" />
    <livewire:datatables.languages />
</x-layouts::dashboard>
