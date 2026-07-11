<div class="border-top" style="background: var(--tblr-bg-surface)">
    <footer class="container py-5">
        <div class="row">
            <div class="col-6 col-md-3 mb-3">
                <h5>{{ __('Quick Links') }}</h5>

                <ul class="nav flex-column">
                    @foreach (\App\Models\StaticPage::select('title', 'slug')->get() as $page)
                        <li class="nav-item mb-2">
                            <a href="{{ route('website.static-pages.show', $page->slug) }}"
                                class="nav-link p-0 text-body-secondary">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <h5>{{ __('Reach Out') }}</h5>

                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link p-0 text-body-secondary">
                            <i class="fas fa-envelope me-2"></i>
                            <span>info@example.com</span>
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link p-0 text-body-secondary">
                            <i class="fas fa-address-card me-2"></i>
                            <span>123 Main St, Anytown, USA</span>
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link p-0 text-body-secondary">
                            <i class="fas fa-phone me-2"></i>
                            <span>+201234567890</span>
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link p-0 text-body-secondary">
                            <i class="fab fa-whatsapp me-2"></i>
                            <span>+201234567890</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-5 offset-md-1 mb-3">
                <x-form>
                    <h5>{{ __('Subscribe to our newsletter') }}</h5>
                    <p>{{ __('Get the latest news and updates.') }}</p>

                    <div class="d-flex flex-column flex-sm-row align-items-start gap-2">
                        <x-input type="email" name="email" :placeholder="__('Enter your email')" validation="required" />
                        <button class="btn btn-primary" type="submit">{{ __('Subscribe') }}</button>
                    </div>
                </x-form>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between text-center pt-4 mt-4 border-top">
            <p>
                &copy; {{ date('Y') }}
                {{ __('All rights reserved for') }}
                <a href="{{ url('/') }}">{{ app_name() }}</a>
            </p>

            <ul class="list-unstyled d-flex justify-content-center">
                <li class="ms-3">
                    <a class="text-muted" href="#">
                        <i class="fab fa-facebook"></i>
                    </a>
                </li>

                <li class="ms-3">
                    <a class="text-muted" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>

                <li class="ms-3">
                    <a class="text-muted" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>
            </ul>
        </div>
    </footer>
</div>
