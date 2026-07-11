<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
{
    /**
     * Refresh the dropdown when notifications change elsewhere on the page.
     */
    #[On('notifications-updated')]
    public function refresh(): void
    {
        //
    }

    /**
     * Render the notifications dropdown.
     */
    public function render()
    {
        $notifications = current_admin()->unreadNotifications()->latest()->limit(5)->get();

        return view('livewire.notifications', [
            'notifications' => $notifications,
        ]);
    }
}
