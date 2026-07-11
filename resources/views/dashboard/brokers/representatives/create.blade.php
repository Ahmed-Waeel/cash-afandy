<x-layouts::dashboard>
    <x-form-card resource="brokers.representatives" :route-params="[$broker]" :data="['clients' => $clients, 'countries' => $countries]" />
</x-layouts::dashboard>
