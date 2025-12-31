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
            'tel' => ['required', 'string', 'regex:/^[0-9]{9}$|^[0-9]{3}\s[0-9]{3}\s[0-9]{3}$/', 'unique:users,tel'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['sometimes', 'in:user,admin'],
        ]);

        // Clean and format phone number: Remove all non-digits, then ensure it's 9 digits
        $telDigits = preg_replace('/\D/', '', $request->tel);
        
        // Validate we have exactly 9 digits (Tanzanian mobile number without country code)
        if (strlen($telDigits) !== 9) {
            return back()->withErrors(['tel' => 'Phone number must be exactly 9 digits (e.g., 712345678 or 712 345 678).'])->withInput();
        }
        
        // Prepend country code: 255
        $tel = '255' . $telDigits;

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

        // Ensure the role exists before assigning (create if it doesn't)
        Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        
        // Assign role to user
        $user->assignRole($role);

        event(new Registered($user));

        // CASE 1: Admin is creating a user (e.g. from admin panel)
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('success', "User '{$user->name}' created successfully as {$role}!");
        }

        // CASE 2: Normal user registering themselves
        Auth::login($user);
        
        // Regenerate session for security (same as login)
        $request->session()->regenerate();
        
        // Get fresh user instance and ensure roles are loaded
        $authenticatedUser = Auth::user();
        $authenticatedUser->refresh();
        $authenticatedUser->load('roles');

        // Redirect based on role:
        // Admin users → Admin Dashboard
        // Regular users → User Dashboard
        if ($authenticatedUser->hasRole('admin')) {
            return redirect()->route('adminDashboard')->with('success', 'Welcome! Registration successful. You have been logged in as an Administrator.');
        }

        // Regular users go to their dashboard
        return redirect()->route('dashboard')->with('success', 'Welcome! Registration successful. You have been logged in.');
    }
}