<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function admin()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'personnel' => User::whereIn('role', ['staff', 'customer'])->count(),
        ];

        return view('admin.dashboard', compact('users', 'stats'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,staff,customer',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User account created successfully!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff,customer',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User account updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return back()->withErrors(['error' => 'You cannot delete your own logged-in account!']);
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User account deleted successfully!');
    }

    public function staff()
    {
        return view('staff.dashboard');
    }

    public function customer()
    {
        return view('customer.dashboard');
    }
}