<?php

namespace App\Http\Controllers\Dashboard;

use Redot\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        return view('dashboard.notifications.index');
    }

    /**
     * Mark the notification as read and redirect to its URL.
     */
    public function visit(string $notification)
    {
        $notification = current_admin()->notifications()->whereKey($notification)->firstOrFail();
        $notification->markAsRead();

        $url = data_get($notification->data, 'url');

        if (! is_string($url) || trim($url) === '') {
            $url = route('dashboard.notifications.index');
        }

        return redirect()->to($url);
    }
}
