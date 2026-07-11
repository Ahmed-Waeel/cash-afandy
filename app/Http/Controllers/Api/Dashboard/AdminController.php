<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Admin;
use App\Notifications\NewAdminNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redot\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'role' => 'required|exists:roles,name',
        ]);

        $password = Str::random(8);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);

        $admin->notify(new NewAdminNotification($password));

        return $this->respond(message: 'Admin created successfully');
    }
}
