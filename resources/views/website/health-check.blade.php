<x-layouts::scaffold class="d-flex align-items-center justify-content-center my-auto h-100">
    <div class="card">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <span class="status-indicator status-green status-indicator-animated">
                        <span class="status-indicator-circle"></span>
                        <span class="status-indicator-circle"></span>
                        <span class="status-indicator-circle"></span>
                    </span>
                </div>

                <div class="col">
                    <h2 class="page-title">
                        {{ __('Health Check') }}
                    </h2>

                    <div class="text-secondary">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                <span class="text-green">{{ __('All systems operational') }}</span>
                            </li>

                            <li class="list-inline-item">{{ now()->toTimeString() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::scaffold>
