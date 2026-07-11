<div wire:poll.15s>
    <x-page-header :title="__('Notifications')" class="mb-3">
        @if ($hasUnread)
            <button type="button" class="btn" wire:click="markAllAsRead" title="{{ __('Mark all as read') }}"
                data-bs-toggle="tooltip">
                <x-icon icon="fa fa-check-double" />
                <span class="d-none d-sm-inline ms-2">{{ __('Mark all as read') }}</span>
            </button>
        @endif

        <nav class="nav nav-segmented nav-3" role="navigation">
            @foreach (['all' => __('All'), 'unread' => __('Unread'), 'read' => __('Read')] as $key => $label)
                <a href="#" wire:click.prevent="$set('status', '{{ $key }}')"
                    @class(['nav-link', 'active' => $status === $key]) @if ($status === $key) aria-current="page" @endif>
                    <span class="nav-link-title">{{ $label }}</span>
                </a>
            @endforeach
        </nav>
    </x-page-header>

    <div class="card">
        <div class="list-group list-group-flush">
            @forelse ($notifications as $notification)
                @include('dashboard.notifications.partials.notification')
            @empty
                <x-empty class="border-0" :title="__('No notifications yet')" :subtitle="__('New notifications will appear here when there is something to review.')" icon="fa fa-bell" />
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>

@script
    <script>
        const timer = liveRelativeTimes($wire.$el);
        document.addEventListener('livewire:navigating', () => clearInterval(timer), {
            once: true
        });
    </script>
@endscript
