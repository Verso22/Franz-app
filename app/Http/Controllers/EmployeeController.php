<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * 📋 List active employees
     */
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('employees', compact('employees'));
    }

    /**
     * ➕ Create form
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * 💾 Store new employee (REAL account creation)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
            'phone'                 => 'nullable|string|max:30',
            'address'               => 'nullable|string|max:255',
            'avatar'                => 'nullable|image|max:2048',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')
                ->store('avatars', 'public');
        }

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'employee',
            'phone'    => $validated['phone'] ?? null,
            'address'  => $validated['address'] ?? null,
            'avatar'   => $avatarPath,
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * ✏️ Edit employee form
     */
    public function edit($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * 💾 Update employee data
     */
    public function update(Request $request, $id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $employee->id,
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'avatar'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * 🗑️ Deactivate employee (convert to customer)
     */
    public function destroy($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);

        $employee->update([
            'role' => 'customer'
        ]);

        return back()->with('success', 'Employee deactivated.');
    }

    /**
     * 🧺 Trash (former employees)
     */
    public function trash()
    {
        $employees = User::where('role', 'customer')->get();
        return view('employees.trash', compact('employees'));
    }

    /**
     * ♻️ Restore employee role
     */
    public function restore($id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);

        $user->update([
            'role' => 'employee'
        ]);

        return back()->with('success', 'Employee restored.');
    }
}
