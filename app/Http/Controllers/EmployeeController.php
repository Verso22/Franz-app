<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->get();

        return view('employees', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')
                ->store('avatars', 'public');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('password123'), // temp password
            'role'     => 'employee',
            'avatar'   => $avatarPath,
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back();
    }

    public function trash()
    {
        $employees = User::onlyTrashed()->get();
        return view('employees.trash', compact('employees'));
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
