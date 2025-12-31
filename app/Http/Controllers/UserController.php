<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('user', compact('users'));
    }
    
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }
        
        // Prevent deleting the last admin
        if ($user->hasRole('admin')) {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot delete the last admin user!');
            }
        }
        
        $user->delete();
        return back()->with('success', "User {$user->name} has been deleted.");
    }
    
    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        // Only admins can edit users
        if (!Auth::user()->hasRole('admin')) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tel' => $user->tel ? substr($user->tel, 3) : '', // Remove country code for display
                'role' => $user->roles->first()?->name ?? 'user',
            ]
        ]);
    }

    /**
     * Update user information
     */
    public function update(Request $request, User $user)
    {
        // Only admins can update users
        if (!Auth::user()->hasRole('admin')) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'tel' => ['required', 'string', 'regex:/^[0-9]{9}$|^[0-9]{3}\s[0-9]{3}\s[0-9]{3}$/'],
        ]);

        // Clean and format phone number
        $telDigits = preg_replace('/\D/', '', $request->tel);
        if (strlen($telDigits) !== 9) {
            return back()->withErrors(['tel' => 'Phone number must be exactly 9 digits.'])->withInput();
        }
        $tel = '255' . $telDigits;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $tel,
        ]);

        return back()->with('success', "User '{$user->name}' updated successfully!");
    }
    
    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        // Only admins can change roles
        if (!Auth::user()->hasRole('admin')) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        // Prevent changing your own role
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role!');
        }
        
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);
        
        // Prevent removing the last admin
        if ($user->hasRole('admin') && $request->role === 'user') {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot remove admin role from the last admin user!');
            }
        }
        
        // Sync roles (remove all and assign new one)
        $user->syncRoles([$request->role]);
        
        return back()->with('success', "User '{$user->name}' role updated to {$request->role}.");
    }
}
