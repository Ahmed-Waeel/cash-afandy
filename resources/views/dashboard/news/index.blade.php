<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.news.create')" class="mb-3" />
    <livewire:datatables.news />
</x-layouts::dashboard>
