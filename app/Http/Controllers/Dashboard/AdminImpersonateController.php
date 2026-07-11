<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redot\Http\Controllers\Controller;

class AdminImpersonateController extends Controller
{
    /**
     * Show the impersonate form.
     */
    public function create()
    {
        $admins = Admin::active()->whereNotCurrentAdmin();

        return view('dashboard.impersonate.admins', [
            'admins' => $admins,
        ]);
    }

    /**
     * Impersonate the given user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => ['required', 'exists:admins,id'],
        ]);

        $admin = Admin::find($request->admin_id);

        if (! $admin || ! $admin->active) {
            return $this->error(__('Admin not found.'));
        }

        Auth::guard('admins')->login($admin);
        toastify()->success(__('Impersonating :name', ['name' => $admin->name]));

        return redirect()->route('dashboard.index');
    }
}
