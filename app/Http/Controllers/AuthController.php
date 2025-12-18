<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // =========================================
    // 🔹 Show login form (PUBLIC)
    // =========================================
    public function showLogin()
    {
        return view('auth.login');
    }

    // =========================================
    // 🔹 Handle login (ROLE-BASED REDIRECT)
    // =========================================
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (!Auth::attempt($credentials)) {
            return back()->with('danger', 'Invalid email or password.');
        }

        // Security: regenerate session
        $request->session()->regenerate();

        $user = Auth::user();

        // =========================
        // ROLE-BASED REDIRECT
        // =========================

        // 👑 Admin → Dashboard
        if ($user->role === 'admin') {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Welcome back, Admin.');
        }

        // 👷 Employee → Dashboard
        if ($user->role === 'employee') {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Welcome back.');
        }

        // 🧍 Customer → Homepage
        return redirect()
            ->route('home')
            ->with('success', 'Welcome to the store!');
    }

    // =========================================
    // 🔹 Show registration form (CUSTOMER ONLY)
    // =========================================
    public function showRegister()
    {
        return view('auth.register');
    }

    // =========================================
    // 🔹 Handle registration (CUSTOMER ONLY)
    // =========================================
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'customer', // 🔒 IMPORTANT: always customer
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. Please login.');
    }

    // =========================================
    // 🔹 Logout (ALL ROLES)
    // =========================================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Everyone goes back to homepage
        return redirect()
            ->route('home')
            ->with('success', 'Logged out successfully.');
    }
}
