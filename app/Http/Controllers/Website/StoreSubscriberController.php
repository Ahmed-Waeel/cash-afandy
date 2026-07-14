<?php

namespace App\Http\Controllers\Website;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;

class StoreSubscriberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'gender' => 'required|string|in:male,female',
        ]);

        $subscriber = Subscriber::updateOrCreate(
            ['email' => $validated['email']],
            ['gender' => $validated['gender']],
        );

        $message = $subscriber->wasRecentlyCreated
            ? __('You have successfully subscribed to our newsletter 🎉')
            : __('You subscription information has been updated successfully 🎉');
        toastify()->success($message);

        return redirect()->back();
    }
}
