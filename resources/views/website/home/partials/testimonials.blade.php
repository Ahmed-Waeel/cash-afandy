<section class="site-testimonials py-5 overflow-hidden">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div class="site-deals-heading">
                <h2 class="mb-1">{{ __('Our Customers Reviews') }}</h2>
                <p class="text-body-secondary mb-0">
                    {{ __('Real experiences from our customers that prove the quality of our services and their satisfaction') }}
                </p>
            </div>

            <div class="site-testimonials-nav d-flex gap-2">
                <button type="button" class="btn btn-icon btn-brand rounded-circle site-testimonials-prev"
                    aria-label="{{ __('Previous') }}">
                    <x-icon icon="fa-solid fa-arrow-left" />
                </button>
                <button type="button" class="btn btn-icon btn-brand rounded-circle site-testimonials-next"
                    aria-label="{{ __('Next') }}">
                    <x-icon icon="fa-solid fa-arrow-right" />
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="testimonials-slider" class="swiper site-testimonials-swiper" tabindex="0">
            <div class="swiper-wrapper align-items-stretch">
                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide h-auto">
                        <div class="site-testimonials-card card h-100 p-4 text-center">
                            <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}"
                                class="site-testimonials-avatar" loading="lazy">

                            <div class="site-testimonials-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <x-icon :icon="$i <= $testimonial['rating'] ? 'fa-solid fa-star' : 'fa-regular fa-star'" />
                                @endfor
                            </div>

                            <p class="site-testimonials-content text-body-secondary mb-3">
                                {{ $testimonial['content'] }}
                            </p>

                            <div class="mt-auto">
                                <div class="fw-bold">{{ $testimonial['name'] }}</div>
                                <div class="text-body-secondary small">{{ $testimonial['title'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="swiper-pagination site-testimonials-pagination position-relative mt-4"></div>
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(() => {
            new Swiper('#testimonials-slider', {
                slidesPerView: 1.15,
                spaceBetween: 16,
                grabCursor: true,
                keyboard: {
                    enabled: true,
                },
                a11y: true,
                pagination: {
                    el: '.site-testimonials-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.site-testimonials-next',
                    prevEl: '.site-testimonials-prev',
                },
                breakpoints: {
                    576: { slidesPerView: 2, spaceBetween: 16 },
                    768: { slidesPerView: 3, spaceBetween: 20 },
                    992: { slidesPerView: 4, spaceBetween: 20 },
                    1200: { slidesPerView: 4.5, spaceBetween: 24 },
                },
            });
        });
    </script>
@endpush
