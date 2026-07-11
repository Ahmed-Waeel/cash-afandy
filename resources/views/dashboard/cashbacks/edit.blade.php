<x-layouts::dashboard>
    <x-form-card resource="cashbacks" :entry="$cashback" :data="['clients' => $clients, 'countries' => $countries, 'representatives' => $representatives]" />
</x-layouts::dashboard>
