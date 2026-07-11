<?php

namespace App\Livewire;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Redot\Toastify\Concerns\InteractsWithToastify;

class NotificationList extends Component
{
    use InteractsWithToastify;
    use WithPagination;

    /**
     * The current status filter.
     */
    #[Url]
    public string $status = 'all';

    /**
     * Reset pagination when the status filter changes.
     */
    public function updatedStatus(): void
    {
        if (! in_array($this->status, ['read', 'unread'], true)) {
            $this->status = 'all';
        }

        $this->resetPage();
    }

    /**
     * Mark the given notification as read.
     */
    public function markAsRead(string $id): void
    {
        $this->findNotification($id)->markAsRead();
        $this->toastify()->success(__('Marked as read successfully'));

        $this->dispatch('notifications-updated');
    }

    /**
     * Mark the given notification as unread.
     */
    public function markAsUnread(string $id): void
    {
        $this->findNotification($id)->markAsUnread();
        $this->toastify()->success(__('Marked as unread successfully'));

        $this->dispatch('notifications-updated');
    }

    /**
     * Mark all of the admin's unread notifications as read.
     */
    public function markAllAsRead(): void
    {
        current_admin()->unreadNotifications()->update(['read_at' => now()]);
        $this->toastify()->success(__('All notifications marked as read'));

        $this->dispatch('notifications-updated');
    }

    /**
     * Delete the given notification.
     */
    public function delete(string $id): void
    {
        $this->findNotification($id)->delete();
        $this->toastify()->success(__('Notification deleted successfully'));

        $this->dispatch('notifications-updated');
    }

    /**
     * Render the notifications listing.
     */
    public function render()
    {
        $query = current_admin()->notifications()->latest();

        match ($this->status) {
            'read' => $query->whereNotNull('read_at'),
            'unread' => $query->whereNull('read_at'),
            default => null,
        };

        return view('livewire.notification-list', [
            'notifications' => $query->paginate(15),
            'hasUnread' => current_admin()->unreadNotifications()->exists(),
        ]);
    }

    /**
     * Find a notification that belongs to the current admin.
     */
    protected function findNotification(string $id): DatabaseNotification
    {
        return current_admin()->notifications()->whereKey($id)->firstOrFail();
    }
}
