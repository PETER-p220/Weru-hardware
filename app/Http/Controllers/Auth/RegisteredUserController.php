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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'tel' => ['required', 'string', 'regex:/^[0-9]{3} [0-9]{3} [0-9]{3}$/', 'unique:users,tel'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['sometimes', 'in:user,admin'],
        ]);

        // Clean and format phone: "712 345 678" → "255712345678"
        $tel = preg_replace('/\s+/', '', $request->tel);
        $tel = '255' . $tel;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $tel,
            'password' => Hash::make($request->password),
        ]);

        // Assign role
        $role = $request->input('role', 'user');
        if (!Role::where('name', $role)->exists()) {
            Role::create(['name' => $role]);
        }
        $user->assignRole($role);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}