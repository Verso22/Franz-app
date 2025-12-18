<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * 🧠 Show the profile page (ALL ROLES)
     */
    public function index()
    {
        return view('profile', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * 👤 Update profile information
     * - name
     * - phone
     * - address
     * - avatar
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'avatar'  => 'nullable|image|max:2048',
        ]);

        // Handle avatar upload ONLY if present
        if ($request->hasFile('avatar')) {

            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        } else {
            // Prevent overwriting avatar with null
            unset($validated['avatar']);
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * 🔐 Update password (ALL ROLES)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('danger', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
