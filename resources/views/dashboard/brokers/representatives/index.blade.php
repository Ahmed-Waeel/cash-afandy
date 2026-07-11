<x-layouts::dashboard>
    <x-page-header :title="__('Representatives')" :pretitle="$broker->title" :create="route('dashboard.brokers.representatives.create', $broker)" class="mb-3" />
    <livewire:datatables.representatives :broker="$broker" />
</x-layouts::dashboard>
