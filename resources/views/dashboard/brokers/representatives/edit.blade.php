<x-layouts::dashboard>
    <x-form-card resource="brokers.representatives" :entry="$representative" :route-params="[$broker]" :data="['clients' => $clients, 'countries' => $countries]" />
</x-layouts::dashboard>
