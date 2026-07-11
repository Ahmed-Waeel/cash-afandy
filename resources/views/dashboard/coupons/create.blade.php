<x-layouts::dashboard>
    <x-form-card resource="coupons" :data="['clients' => $clients, 'countries' => $countries, 'representatives' => $representatives]" />
</x-layouts::dashboard>
