<x-layouts::website>
    @if ($sliders->isNotEmpty())
        @include('website.home.partials.hero-slider')
    @endif

    @if (! empty($coupons))
        @include('website.home.partials.latest-coupons')
    @endif

    @if (! empty($cashbackStores))
        @include('website.home.partials.latest-cashback-stores')
    @endif

    @if (! empty($cashbackSteps))
        @include('website.home.partials.how-to-get-cashback')
    @endif

    @if ($clients->isNotEmpty())
        @include('website.home.partials.our-partners')
    @endif

    @if (! empty($testimonials))
        @include('website.home.partials.testimonials')
    @endif
</x-layouts::website>
