<section class="mb-5">
    <div id="hero-slider" class="swiper site-hero-slider">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <div class="position-relative w-100 h-100 d-flex align-items-center"
                        style="background: center / {{ $slider->background_size }} no-repeat url('{{ $slider->image }}')">
                        <div class="position-absolute top-0 start-0 end-0 bottom-0"
                            style="background-color: {{ $slider->background }}"></div>

                        <div class="container position-relative"
                            style="color: {{ $slider->foreground }}; --slider-foreground: {{ $slider->foreground }}">
                            <h1 class="display-5 mb-3">{{ $slider->title }}</h1>

                            @if ($slider->description)
                                <div class="lead mb-4 subtitle">{!! $slider->description !!}</div>
                            @endif

                            @if (! empty($slider->buttons))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($slider->buttons as $button)
                                        <a href="{{ $button['url'] }}" class="btn btn-{{ $button['type'] }} btn-lg">
                                            {{ $button['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($sliders->count() > 1)
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        @endif
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(() => {
            new Swiper('#hero-slider', {
                direction: 'horizontal',
                loop: {{ $sliders->count() > 1 ? 'true' : 'false' }},
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '#hero-slider .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '#hero-slider .swiper-button-next',
                    prevEl: '#hero-slider .swiper-button-prev',
                },
                keyboard: { enabled: true },
                a11y: true,
            });
        });
    </script>
@endpush
