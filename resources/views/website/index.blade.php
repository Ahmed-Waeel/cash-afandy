<x-layouts::website>
    @if ($sliders->isNotEmpty())
        @include('website.home.partials.hero-slider')
    @endif

    <div class="container">
        <div class="row row-deck row-cards">
            <div class="col-4">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::website>
