@php
    $level = \App\Enums\NotificationLevel::resolve(data_get($notification->data, 'level'));
    $title = data_get($notification->data, 'title') ?: __('Notification');
    $unread = $notification->unread();
@endphp

<div class="list-group-item" wire:key="notification-{{ $notification->id }}">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <span @class([
                'status-dot',
                'status-dot-animated bg-' . $level->color() => $unread,
            ])></span>
        </div>

        <a href="{{ route('dashboard.notifications.visit', $notification) }}"
            class="col min-width-0 text-decoration-none">
            <span class="text-body fw-bold d-block text-truncate">
                {{ $title }}
            </span>

            <div class="text-secondary small">
                @if ($notification->created_at)
                    <span>{{ __('Created') }}
                        <time relative-time
                            datetime="{{ $notification->created_at->toIso8601String() }}">{{ $notification->created_at->diffForHumans() }}</time>
                    </span>
                @endif

                @if ($notification->read_at)
                    <span class="mx-1">&middot;</span>
                    <span>{{ __('Read') }}
                        <time relative-time
                            datetime="{{ $notification->read_at->toIso8601String() }}">{{ $notification->read_at->diffForHumans() }}</time>
                    </span>
                @endif
            </div>
        </a>

        <div class="col-auto">
            <div class="btn-list flex-nowrap">
                @if ($unread)
                    <button type="button" class="btn btn-icon" wire:click="markAsRead('{{ $notification->id }}')"
                        title="{{ __('Mark as read') }}">
                        <x-icon icon="fa fa-envelope-open" />
                    </button>
                @else
                    <button type="button" class="btn btn-icon" wire:click="markAsUnread('{{ $notification->id }}')"
                        title="{{ __('Mark as unread') }}">
                        <x-icon icon="fa fa-envelope" />
                    </button>
                @endif

                <button type="button" class="btn btn-icon btn-danger" wire:click="delete('{{ $notification->id }}')"
                    title="{{ __('Delete') }}">
                    <x-icon icon="fa fa-trash" />
                </button>
            </div>
        </div>
    </div>
</div>
