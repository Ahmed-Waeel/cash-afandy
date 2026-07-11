<x-layouts::dashboard>
    <x-form-card resource="coupons" :entry="$coupon" :data="['clients' => $clients, 'countries' => $countries, 'representatives' => $representatives]" />
</x-layouts::dashboard>
