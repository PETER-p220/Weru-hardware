<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; // ← CORRECT
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'tel' => ['required', 'string', 'regex:/^[0-9]{3} [0-9]{3} [0-9]{3}$/'],
        'password' => ['required', 'confirmed', Password::defaults()],
        'role' => ['sometimes', 'in:user,admin'],
    ]);

    // Clean phone number
    $tel = '255' . preg_replace('/\D/', '', $request->tel);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'tel' => $tel,
        'password' => Hash::make($request->password),
    ]);

    // === SAFE ROLE ASSIGNMENT ===
    $role = 'user'; // default

    // Only allow role change if current user is admin
    if (auth()->check() && auth()->user()->hasRole('admin') && $request->filled('role')) {
        $role = $request->role; // 'user' or 'admin'
    }

    $user->assignRole($role);

    event(new Registered($user));

    // If admin is creating the account, stay on page
    if (auth()->check()) {
        return redirect()->back()->with('success', "User {$user->name} created as {$role}!");
    }

    Auth::login($user);
    return redirect()->route('dashboard');
}
}