<li class="nav-item dropdown dashboard-notifications" wire:poll.10s>
    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" data-bs-auto-close="outside"
        wire:ignore.self>
        <i class="fa fa-bell"></i>

        @if ($notifications->count() > 0)
            <span class="badge bg-danger badge-dot"></span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card" wire:ignore.self>
        <div class="card">
            <div class="list-group-item text-center py-2 text-secondary small border-bottom">
                <b>{{ __('Notifications') }}</b>
            </div>

            <div class="list-group list-group-flush list-group-hoverable">
                @forelse ($notifications as $notification)
                    @include('layouts.dashboard.partials.navbar.notification', [
                        'notification' => $notification,
                    ])
                @empty
                    <div class="list-group-item text-center text-secondary">
                        {{ __('You are all caught up.') }}
                    </div>
                @endforelse
            </div>

            <a href="{{ route('dashboard.notifications.index') }}"
                class="list-group-item-action text-center py-2 text-secondary small border-top">
                {{ __('View all notifications') }}
            </a>
        </div>
    </div>
</li>

@script
<script>
    const timer = liveRelativeTimes($wire.$el, { style: 'narrow' });
    document.addEventListener('livewire:navigating', () => clearInterval(timer), { once: true });
</script>
@endscript
