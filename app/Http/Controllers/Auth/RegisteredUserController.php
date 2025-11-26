<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tel' => ['required', 'string', 'regex:/^[0-9]{3} [0-9]{3} [0-9]{3}$/', 'unique:users,tel'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['sometimes', 'in:user,admin'],
        ]);

        // Clean and format phone number: e.g. "255 712 345 678" → "255712345678"
        $tel = '255' . preg_replace('/\D/', '', $request->tel);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $tel,
            'password' => Hash::make($request->password),
        ]);

        // Default role
        $role = 'user';

        // Only admin can assign roles (including creating other admins)
        if (auth()->check() && auth()->user()->hasRole('admin') && $request->filled('role')) {
            $role = $request->role; // 'user' or 'admin'
        }

        $user->assignRole($role);

        event(new Registered($user));

        // CASE 1: Admin is creating a user (e.g. from admin panel)
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('success', "User '{$user->name}' created successfully as {$role}!");
        }

        // CASE 2: Normal user registering themselves
        Auth::login($user);

        // Redirect based on role
        if ($user->hasRole('admin')) {
            return redirect()->route('adminDashboard'); // e.g. /admin/dashboard
        }

        return redirect()->route('dashboard'); // Regular user dashboard
    }
}