<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redot\Http\Controllers\Controller;

class UserImpersonateController extends Controller
{
    /**
     * Show the impersonate form.
     */
    public function create()
    {
        $users = User::query();

        return view('dashboard.impersonate.users', [
            'users' => $users,
        ]);
    }

    /**
     * Impersonate the given user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::find($request->user_id);

        if (! $user || $user->trashed()) {
            return $this->error(__('User not found.'));
        }

        Auth::guard('users')->login($user);
        toastify()->success(__('Impersonating :name', ['name' => $user->full_name]));

        return redirect()->route('website.index');
    }
}
