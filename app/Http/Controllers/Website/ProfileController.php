<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Redot\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('website.profile.edit', [
            'user' => current_user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
            'password' => ['nullable', 'confirmed', 'min:8', Password::defaults()],
        ]);

        $user = $request->user();
        $user->fill($request->only('first_name', 'last_name', 'email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->filled('password')) {
            $user->password = $request->get('password');
        }

        $user->save();

        return $this->updated(__('Profile'));
    }

    /**
     * Update the authenticated user's preferences.
     */
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['required', 'string', 'in:light,dark'],
            'language' => ['required', 'string', 'in:' . implode(',', setting('website_locales'))],
            'country_id' => ['nullable', 'exists:countries,id'],
        ]);

        $request->user()->preferences()->update($validated);

        return $this->updated(__('Preferences'));
    }
}
