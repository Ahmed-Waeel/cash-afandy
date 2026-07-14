<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Subscriber;
use Redot\Http\Controllers\Controller;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.subscribers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return $this->deleted(__('Subscriber'), 'dashboard.subscribers.index');
    }
}
