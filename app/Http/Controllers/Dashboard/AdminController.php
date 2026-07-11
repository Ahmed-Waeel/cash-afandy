<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use App\Notifications\NewAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redot\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'role' => 'nullable|exists:roles,name',
        ]);

        $password = Str::random(8);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
            'active' => $request->has('active'),
        ]);

        if ($validated['role']) {
            $admin->assignRole($validated['role']);
        }

        $admin->notify(new NewAdminNotification($password));

        return $this->created(__('Admin'), 'dashboard.admins.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('dashboard.admins.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'role' => 'nullable|exists:roles,name',
        ]);

        cache()->flush(); // Clear cache to refresh permissions

        // Sync roles for the admin
        $admin->syncRoles($validated['role']);

        $admin->update([
            'active' => $request->has('active'),
        ]);

        return $this->updated(__('Admin'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->id === current_admin()->id) {
            return back()->with('error', __('You cannot delete yourself.'));
        }

        $admin->delete();

        return $this->deleted(__('Admin'));
    }
}
