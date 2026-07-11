@php
    $level = \App\Enums\NotificationLevel::resolve(data_get($notification->data, 'level'));
    $title = data_get($notification->data, 'title') ?: __('Notification');
@endphp

<a href="{{ route('dashboard.notifications.visit', $notification) }}"
    class="list-group-item list-group-item-action d-flex align-items-center gap-3">
    <span class="status-dot status-dot-animated bg-{{ $level->color() }}"></span>
    <span class="flex-fill w-0 text-truncate text-body">{{ $title }}</span>

    @if ($notification->created_at)
        <small class="text-secondary text-nowrap">
            <time relative-time datetime="{{ $notification->created_at->toIso8601String() }}">{{ $notification->created_at->diffForHumans(short: true) }}</time>
        </small>
    @endif
</a>
