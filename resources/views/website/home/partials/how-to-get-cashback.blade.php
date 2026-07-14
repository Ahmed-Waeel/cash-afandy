<section class="site-cashback-steps py-5">
    <div class="container">
        <div class="site-deals-heading text-center text-md-start mb-5">
            <h2 class="mb-1">{{ __('How do you get cashback') }}</h2>
            <p class="text-body-secondary mb-0">
                {{ __('All you have to do is follow the next steps to get a cash refund on your purchases') }}
            </p>
        </div>

        <div class="row">
            @php
                $stepColors = ['var(--Lightest-Red)', 'var(--Light-Red)', 'var(--Dark-Red)', 'var(--Darkest-Red)'];
            @endphp

            @foreach ($cashbackSteps as $index => $step)
                <div class="col-6 col-lg-3 text-center mb-4 mb-lg-0">
                    <div class="site-cashback-orbit mx-auto mb-3 {{ ($index + 1) % 2 === 0 ? 'site-cashback-orbit-reverse' : '' }}"
                        style="--step-color: {{ $stepColors[$index % 4] }}">
                        <span class="site-cashback-node site-cashback-node-start"></span>
                        <span class="site-cashback-node site-cashback-node-end"></span>

                        <div class="site-cashback-circle">
                            <span class="site-cashback-number">{{ sprintf('%02d', $index + 1) }}</span>
                        </div>
                    </div>

                    <h4 class="mb-2">{{ $step['title'] }}</h4>
                    <p class="text-body-secondary small mb-0">{{ $step['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
