<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // =========================================
    // 🔹 Show login form
    // =========================================
    public function showLogin()
    {
        // Show the login page
        return view('auth.login');
    }

    // =========================================
    // 🔹 Handle login request (ROLE-BASED REDIRECT)
    // =========================================
    public function login(Request $request)
    {
        // 👶 Step 1: Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 👶 Step 2: Try to login
        if (Auth::attempt($credentials)) {

            // 🔐 Regenerate session (security)
            $request->session()->regenerate();

            // 👤 Get logged-in user
            $user = Auth::user();

            // 🧍 CUSTOMER → Storefront
            if ($user->role === 'customer') {
                return redirect()->route('store.index')
                    ->with('success', 'Welcome to the store!');
            }

            // 👑 ADMIN / 👷 EMPLOYEE → Dashboard
            return redirect()->route('dashboard')
                ->with('success', 'Welcome back!');
        }

        // ❌ If login fails
        return back()->with('danger', 'Invalid credentials.');
    }

    // =========================================
    // 🔹 Show registration form
    // =========================================
    public function showRegister()
    {
        // Show the register page
        return view('auth.register');
    }

    // =========================================
    // 🔹 Handle registration
    // =========================================
    public function register(Request $request)
    {
        // 👶 Validate registration input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // 👶 Create new user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),

            // 🚨 IMPORTANT:
            // Default role is EMPLOYEE (same as your original logic)
            // We will later change this when we add CUSTOMER registration
            'role'     => 'employee',
        ]);

        // 🔐 Auto login after register
        Auth::login($user);

        // 👑 New users go to dashboard (admin/employee area)
        return redirect()->route('dashboard')
            ->with('success', 'Account created successfully!');
    }

    // =========================================
    // 🔹 Logout
    // =========================================
    public function logout(Request $request)
    {
        // 👋 Logout user
        Auth::logout();

        // 🔐 Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔁 Redirect to login
        return redirect('/login')
            ->with('success', 'Logged out successfully.');
    }
}
