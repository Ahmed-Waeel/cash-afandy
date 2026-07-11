<x-layouts::dashboard>
    <x-page-header :create="route('dashboard.coupons.create')" class="mb-3" />
    <livewire:datatables.coupons />
</x-layouts::dashboard>
