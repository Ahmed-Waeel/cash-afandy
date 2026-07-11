<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.memos.create')" class="mb-3" />
    <livewire:datatables.memos />
</x-layouts::dashboard>
