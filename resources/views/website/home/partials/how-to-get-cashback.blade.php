<section class="site-cashback-steps py-5">
    <div class="container">
        <div class="site-deals-heading text-center text-md-start mb-5">
            <h2 class="mb-1">{{ __('How do you get cashback') }}</h2>
            <p class="text-body-secondary mb-0">
                {{ __('All you have to do is follow the next steps to get a cash refund on your purchases') }}
            </p>
        </div>

        <div class="row">
            <div class="col-6 col-lg-3 text-center mb-4 mb-lg-0">
                <div class="site-cashback-orbit mx-auto mb-3" style="--step-color: var(--Lightest-Red)">
                    <span class="site-cashback-node site-cashback-node-start"></span>
                    <span class="site-cashback-node site-cashback-node-end"></span>

                    <div class="site-cashback-circle">
                        <span class="site-cashback-number">01</span>
                    </div>
                </div>

                <h4 class="mb-2">Sign up on {{ app_name() }}</h4>
                <p class="text-body-secondary small mb-0">
                    Easily create a new account on {{ app_name() }} or log in if you already have an account
                </p>
            </div>

            <div class="col-6 col-lg-3 text-center mb-4 mb-lg-0">
                <div class="site-cashback-orbit site-cashback-orbit-reverse mx-auto mb-3"
                    style="--step-color: var(--Light-Red)">
                    <span class="site-cashback-node site-cashback-node-start"></span>
                    <span class="site-cashback-node site-cashback-node-end"></span>

                    <div class="site-cashback-circle">
                        <span class="site-cashback-number">02</span>
                    </div>
                </div>

                <h4 class="mb-2">Browse the cashback section</h4>
                <p class="text-body-secondary small mb-0">
                    You will find many featured stores on {{ app_name() }}, all you have to do is choose one of
                    them
                </p>
            </div>

            <div class="col-6 col-lg-3 text-center mb-4 mb-lg-0">
                <div class="site-cashback-orbit mx-auto mb-3" style="--step-color: var(--Dark-Red)">
                    <span class="site-cashback-node site-cashback-node-start"></span>
                    <span class="site-cashback-node site-cashback-node-end"></span>

                    <div class="site-cashback-circle">
                        <span class="site-cashback-number">03</span>
                    </div>
                </div>

                <h4 class="mb-2">Complete the purchase</h4>
                <p class="text-body-secondary small mb-0">
                    Go to the store and complete the purchase process as usual without any additional steps
                </p>
            </div>

            <div class="col-6 col-lg-3 text-center mb-4 mb-lg-0">
                <div class="site-cashback-orbit site-cashback-orbit-reverse mx-auto mb-3"
                    style="--step-color: var(--Darkest-Red)">
                    <span class="site-cashback-node site-cashback-node-start"></span>
                    <span class="site-cashback-node site-cashback-node-end"></span>

                    <div class="site-cashback-circle">
                        <span class="site-cashback-number">04</span>
                    </div>
                </div>

                <h4 class="mb-2">Wait for the cashback in your account</h4>
                <p class="text-body-secondary small mb-0">
                    Wait for the cashback amount to appear in your account on {{ app_name() }}, then you can
                    withdraw it later
                </p>
            </div>
        </div>
    </div>
</section>
